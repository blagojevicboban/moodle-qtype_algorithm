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

use core_external\external_multiple_structure;
use core_external\external_single_structure;
use core_external\external_value;
use qtype_algorithm\local\analysis;

/**
 * The analysis of the answers of the class to one slot of a quiz (the last attempt of each student, the same students
 * as the class view): tests, wrong outputs, errors, missing structures, grades and the blocks of the solution the wrong
 * answers miss. Only the answers to the version of the question most students got are analysed.
 *
 * @package    qtype_algorithm
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class get_class_analysis extends get_class_answers {
    /**
     * The analysis.
     *
     * @param int $cmid course module of the quiz
     * @param int $slot slot of the question
     * @return array
     */
    public static function execute(int $cmid, int $slot): array {
        $attempts = self::class_attempts($cmid, $slot);
        $empty = analysis::analyse_empty();
        if (!$attempts) {
            return $empty;
        }
        // The version most students got (a quiz may have been changed after some attempts).
        $versions = array_count_values(array_column($attempts, 'questionid'));
        arsort($versions);
        $questionid = (int) array_key_first($versions);
        $found = self::last_answers(array_column($attempts, 'qaid'));
        $answers = [];
        foreach ($attempts as $att) {
            $f = $found[$att['qaid']] ?? null;
            if ($att['questionid'] === $questionid && $f && $f['answer'] !== null) {
                $answers[] = ['answer' => (string) $f['answer'], 'fraction' => $f['fraction'], 'time' => $f['time']];
            }
        }
        usort($answers, fn($a, $b) => $b['time'] <=> $a['time']);
        $question = \question_bank::load_question($questionid);
        $result = analysis::analyse($question, array_slice($answers, 0, self::MAX_ANSWERS));
        foreach ($result['structures'] as $k => $s) {
            $result['structures'][$k]['label'] = get_string('structure_' . $s['name'], 'qtype_algorithm');
        }
        $result['otherversions'] = count($attempts) - ($versions[$questionid] ?? 0);
        $result['solution'] = json_encode(\qtype_algorithm_question::decode_answer((string) $question->solution));
        return $result;
    }

    /**
     * Result.
     *
     * @return external_single_structure
     */
    public static function execute_returns(): external_single_structure {
        $count = fn($text) => new external_value(PARAM_INT, $text);
        return new external_single_structure([
            'count' => $count('Answers analysed'),
            'graded' => $count('Answers with a grade'),
            'histogram' => new external_multiple_structure($count('Answers with a grade from 10 k % to 10 (k + 1) %')),
            'norun' => $count('Answers that end with an error in every test'),
            'efficiency' => $count('Answers that are not efficient enough'),
            'tests' => new external_multiple_structure(new external_single_structure([
                'n' => $count('Number of the test'),
                'label' => new external_value(PARAM_RAW, 'Inputs or the call of the test'),
                'hidden' => new external_value(PARAM_BOOL, 'Hidden test'),
                'passed' => $count('Answers that pass it'),
                'failed' => $count('Answers that fail it'),
                'errors' => $count('Answers that end with an error in it'),
                'outputs' => new external_multiple_structure(new external_single_structure([
                    'output' => new external_value(PARAM_RAW, 'A wrong output'),
                    'count' => $count('Answers with this output'),
                ])),
            ])),
            'errors' => new external_multiple_structure(new external_single_structure([
                'message' => new external_value(PARAM_RAW, 'Error message'),
                'count' => $count('Answers with this error'),
            ])),
            'structures' => new external_multiple_structure(new external_single_structure([
                'name' => new external_value(PARAM_ALPHA, 'Required structure'),
                'label' => new external_value(PARAM_TEXT, 'Its name in the language of the user'),
                'count' => $count('Answers without it'),
            ])),
            'medianblocks' => new external_value(PARAM_FLOAT, 'Median number of blocks of the answers'),
            'solutionblocks' => $count('Blocks of the solution'),
            'mediansteps' => new external_value(PARAM_FLOAT, 'Median steps of the answers in all tests together'),
            'failing' => $count('Answers that fail a test'),
            'blocks' => new external_multiple_structure(new external_single_structure([
                'id' => new external_value(PARAM_RAW, 'Block of the solution'),
                'missing' => new external_value(PARAM_FLOAT, 'Share of the wrong answers without a block like it'),
            ])),
            'otherversions' => $count('Answers to another version of the question, not analysed'),
            'solution' => new external_value(PARAM_RAW, 'The solution (JSON), null when there is none'),
        ]);
    }
}
