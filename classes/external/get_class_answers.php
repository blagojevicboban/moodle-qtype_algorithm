<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

namespace qtype_algorithm\external;

use core_external\external_api;
use core_external\external_function_parameters;
use core_external\external_multiple_structure;
use core_external\external_single_structure;
use core_external\external_value;

/**
 * The answers of the students to one slot of a quiz (the last attempt of each student), newest first, for the class
 * view of the teacher: the diagram, the time it was saved and the grade. Previews are left out. In a quiz with separate
 * groups, a teacher who cannot see all groups gets only the students of their own groups.
 *
 * @package    qtype_algorithm
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class get_class_answers extends external_api {
    /** Most answers returned. */
    const MAX_ANSWERS = 200;

    /**
     * Parameters.
     *
     * @return external_function_parameters
     */
    public static function execute_parameters(): external_function_parameters {
        return new external_function_parameters([
            'cmid' => new external_value(PARAM_INT, 'The quiz'),
            'slot' => new external_value(PARAM_INT, 'The slot of the question in the quiz'),
        ]);
    }

    /**
     * The answers of the class.
     *
     * @param int $cmid course module of the quiz
     * @param int $slot slot of the question
     * @return array
     */
    public static function execute(int $cmid, int $slot): array {
        global $DB;
        $attempts = self::class_attempts($cmid, $slot);
        if (!$attempts) {
            return ['answers' => []];
        }

        $found = self::last_answers(array_column($attempts, 'qaid'));
        $fields = \core_user\fields::for_name()->get_sql('', false, '', '', false)->selects;
        $users = $DB->get_records_list('user', 'id', array_keys($attempts), '', 'id, deleted' . ($fields ? ", {$fields}" : ''));
        $out = [];
        foreach ($attempts as $userid => $att) {
            $qaid = $att['qaid'];
            $user = $users[$userid] ?? null;
            $f = $found[$qaid] ?? null;
            $model = $f && $f['answer'] !== null ? \qtype_algorithm_question::decode_answer((string) $f['answer']) : null;
            if (!$user || $user->deleted || !$model) {
                continue;
            }
            $out[] = ['userid' => (int) $userid, 'fullname' => fullname($user), 'program' => json_encode($model),
                'timemodified' => $f['time'], 'fraction' => $f['fraction'] ?? -1.0];
        }
        usort($out, fn($a, $b) => $b['timemodified'] <=> $a['timemodified']);
        return ['answers' => array_slice($out, 0, self::MAX_ANSWERS)];
    }

    /**
     * The last attempt of each student the teacher may see at this slot, after checking the capability.
     *
     * @param int $cmid course module of the quiz
     * @param int $slot slot of the question
     * @return array user id => ['qaid' => question attempt id, 'questionid' => question id]
     */
    protected static function class_attempts(int $cmid, int $slot): array {
        global $CFG, $DB;
        require_once($CFG->dirroot . '/question/type/algorithm/question.php');
        $params = self::validate_parameters(self::execute_parameters(), ['cmid' => $cmid, 'slot' => $slot]);
        $cm = get_coursemodule_from_id('quiz', $params['cmid'], 0, false, MUST_EXIST);
        $context = \context_module::instance($cm->id);
        self::validate_context($context);
        require_capability('mod/quiz:viewreports', $context);

        // The last attempt of each student that has this slot as an algorithm question.
        $rows = $DB->get_recordset_sql(
            "SELECT qa.id, qa.questionid, quiza.userid, quiza.attempt
               FROM {quiz_attempts} quiza
               JOIN {question_attempts} qa ON qa.questionusageid = quiza.uniqueid
               JOIN {question} q ON q.id = qa.questionid
              WHERE quiza.quiz = :quiz AND quiza.preview = 0 AND qa.slot = :slot AND q.qtype = :qtype
           ORDER BY quiza.userid, quiza.attempt DESC",
            ['quiz' => $cm->instance, 'slot' => $params['slot'], 'qtype' => 'algorithm']
        );
        $attempts = [];
        foreach ($rows as $row) {
            if (!isset($attempts[$row->userid])) {
                $attempts[$row->userid] = ['qaid' => (int) $row->id, 'questionid' => (int) $row->questionid];
            }
        }
        $rows->close();

        $allowed = self::allowed_users($cm, $context);
        return $allowed === null ? $attempts : array_intersect_key($attempts, $allowed);
    }

    /**
     * The students the teacher may see: null for all, or the members of the teacher's groups in separate groups mode.
     *
     * @param \stdClass $cm course module of the quiz
     * @param \context_module $context its context
     * @return array|null user id => true
     */
    protected static function allowed_users(\stdClass $cm, \context_module $context): ?array {
        global $USER;
        if (
            groups_get_activity_groupmode($cm) != SEPARATEGROUPS
                || has_capability('moodle/site:accessallgroups', $context)
        ) {
            return null;
        }
        $allowed = [];
        foreach (groups_get_all_groups($cm->course, $USER->id, $cm->groupingid) as $group) {
            foreach (groups_get_members($group->id, 'u.id') as $member) {
                $allowed[$member->id] = true;
            }
        }
        return $allowed;
    }

    /**
     * The last answer, its time and the last grade of each question attempt.
     *
     * @param int[] $qaids question attempt ids
     * @return array question attempt id => ['answer' => ?string, 'time' => int, 'fraction' => ?float]
     */
    protected static function last_answers(array $qaids): array {
        global $DB;
        $found = [];
        foreach (array_chunk($qaids, 500) as $chunk) {
            [$insql, $inparams] = $DB->get_in_or_equal($chunk, SQL_PARAMS_NAMED);
            $steps = $DB->get_recordset_sql(
                "SELECT qas.id, qas.questionattemptid, qas.fraction, qas.timecreated, qasd.value
                   FROM {question_attempt_steps} qas
              LEFT JOIN {question_attempt_step_data} qasd ON qasd.attemptstepid = qas.id AND qasd.name = :name
                  WHERE qas.questionattemptid {$insql}
               ORDER BY qas.questionattemptid, qas.sequencenumber",
                ['name' => 'answer'] + $inparams
            );
            foreach ($steps as $step) {
                $f = $found[$step->questionattemptid] ?? ['answer' => null, 'time' => 0, 'fraction' => null];
                if ($step->value !== null) {
                    $f['answer'] = $step->value;
                    $f['time'] = (int) $step->timecreated;
                }
                if ($step->fraction !== null) {
                    $f['fraction'] = (float) $step->fraction;
                }
                $found[$step->questionattemptid] = $f;
            }
            $steps->close();
        }
        return $found;
    }

    /**
     * Result.
     *
     * @return external_single_structure
     */
    public static function execute_returns(): external_single_structure {
        return new external_single_structure([
            'answers' => new external_multiple_structure(new external_single_structure([
                'userid' => new external_value(PARAM_INT, 'The student'),
                'fullname' => new external_value(PARAM_TEXT, 'Name of the student'),
                'program' => new external_value(PARAM_RAW, 'The algorithm (JSON)'),
                'timemodified' => new external_value(PARAM_INT, 'When the answer was saved'),
                'fraction' => new external_value(PARAM_FLOAT, 'Grade from 0 to 1, -1 when not graded yet'),
            ])),
        ]);
    }
}
