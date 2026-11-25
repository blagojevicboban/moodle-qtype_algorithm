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

/**
 * Question type class for the Algorithm question type.
 *
 * @package    qtype_algorithm
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use qtype_algorithm\local\growth;
use qtype_algorithm\local\tester;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/questionlib.php');
require_once($CFG->dirroot . '/question/type/algorithm/question.php');

/**
 * The Algorithm question type: the student draws an algorithm as a flowchart. With tests it is graded automatically
 * (the expected outputs come from the teacher's solution), without tests the teacher grades it.
 *
 * @package    qtype_algorithm
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_algorithm extends question_type {
    /** Structures a question can require. */
    const STRUCTURES = ['if', 'for', 'while', 'dowhile', 'array', 'matrix', 'record'];

    /**
     * Extra fields kept in qtype_algorithm_options (also used for backup and restore).
     *
     * @return array
     */
    public function extra_question_fields() {
        return ['qtype_algorithm_options', 'solution', 'template', 'tests', 'afterinput', 'numbers', 'structures', 'showtests',
            'grademethod', 'ignorecase', 'ignorespaces', 'tolerance', 'hidetools', 'parsons', 'distractors', 'stepfactor',
            'maxgrowth', 'maxblocks', 'efficiencypenalty', 'aihints', 'gaps', 'ordercheck', 'strictinit'];
    }

    /**
     * Questions without tests need a teacher's grade; this is decided per question.
     *
     * @return bool
     */
    public function is_manual_graded() {
        return false;
    }

    /**
     * This type stores no files with the response.
     *
     * @return array
     */
    public function response_file_areas() {
        return [];
    }

    /**
     * Random questions may pick algorithm questions (those without tests are then graded by the teacher).
     *
     * @return bool
     */
    public function is_usable_by_random() {
        return true;
    }

    /**
     * The quiz statistics show, for every test, how many answers passed it.
     *
     * @return bool
     */
    public function can_analyse_responses() {
        return true;
    }

    /**
     * Possible results of every test, for the response analysis of the quiz statistics.
     *
     * @param stdClass $questiondata the question data
     * @return array test index => [class => question_possible_response]
     */
    public function get_possible_responses($questiondata) {
        $tests = json_decode((string) ($questiondata->options->tests ?? ''), true);
        $parts = [];
        foreach (is_array($tests) ? array_keys($tests) : [] as $i) {
            $parts[$i] = [
                'pass' => new question_possible_response(get_string('testpassed', 'qtype_algorithm', $i + 1), 1),
                'fail' => new question_possible_response(get_string('testfailed', 'qtype_algorithm', $i + 1), 0),
                'error' => new question_possible_response(get_string('testerror', 'qtype_algorithm', $i + 1), 0),
                null => question_possible_response::no_response(),
            ];
        }
        return $parts;
    }

    /**
     * A random guess has no score.
     *
     * @param stdClass $questiondata the question data
     * @return int|null
     */
    public function get_random_guess_score($questiondata) {
        return empty($questiondata->options->tests) ? null : 0;
    }

    /**
     * What is compared in the tests.
     *
     * @param stdClass $data question options or form data
     * @return array ['afterinput' => bool, 'numbers' => bool, 'ignorecase' => bool, 'ignorespaces' => bool, 'tolerance' => float]
     */
    public static function check_options($data): array {
        return ['afterinput' => !empty($data->afterinput), 'numbers' => !empty($data->numbers),
            'ignorecase' => !empty($data->ignorecase), 'ignorespaces' => !empty($data->ignorespaces),
            'tolerance' => max(0.0, (float) ($data->tolerance ?? 0))];
    }

    /**
     * A test with only the fields a test keeps: inputs, hidden, and when set weight, call (a function test) and
     * manual with the expected output the teacher typed.
     *
     * @param array $tc test
     * @return array
     */
    public static function clean_test(array $tc): array {
        $out = ['inputs' => (string) ($tc['inputs'] ?? ''), 'hidden' => !empty($tc['hidden'])];
        if (!empty($tc['manual'])) {
            $out['manual'] = true;
            $out['expected'] = (string) ($tc['expected'] ?? '');
        }
        if (isset($tc['weight']) && is_numeric($tc['weight']) && (float) $tc['weight'] >= 0) {
            $out['weight'] = (float) $tc['weight'];
        }
        if (isset($tc['call']) && preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/', (string) $tc['call'])) {
            $out['call'] = (string) $tc['call'];
        }
        return $out;
    }

    /**
     * Tests with the expected outputs computed from the solution.
     *
     * @param string $solution the teacher's algorithm (base64 encoded JSON)
     * @param mixed $tests JSON text or list of tests ['inputs' => ..., 'hidden' => ...]
     * @param array $check what is compared
     * @param bool $strict strict initialization (a variable must get a value before it is read)
     * @return array ['tests' => list, 'errors' => [['index' => i, 'error' => message]]]
     */
    public static function compute_tests(string $solution, $tests, array $check, bool $strict = false): array {
        $list = is_string($tests) ? json_decode($tests, true) : $tests;
        $list = array_values(array_filter(is_array($list) ? $list : [], 'is_array'));
        $list = array_map([self::class, 'clean_test'], $list);
        if (!$list) {
            return ['tests' => [], 'errors' => []];
        }
        $program = qtype_algorithm_question::decode_answer($solution);
        if (!$program) {
            return ['tests' => $list, 'errors' => [['index' => -1, 'error' => get_string('nosolution', 'qtype_algorithm')]]];
        }
        if ($strict) {
            $program['strictInit'] = true;
        } else {
            unset($program['strictInit']);
        }
        return tester::compute_expected($program, $list, $check, get_string('noinput', 'qtype_algorithm'));
    }

    /**
     * Save the options; the expected outputs of the tests are computed here from the solution.
     *
     * @param stdClass $question form data
     * @return bool|stdClass
     */
    public function save_question_options($question) {
        $question->solution = (string) ($question->solution ?? '');
        if (isset($question->usetemplate) && empty($question->usetemplate)) {
            $question->template = '';
        }
        $question->template = (string) ($question->template ?? '');
        if (is_array($question->structures ?? null)) {
            $question->structures = implode(',', array_keys(array_filter($question->structures)));
        }
        $question->structures = implode(',', array_intersect(
            self::STRUCTURES,
            explode(',', (string) ($question->structures ?? ''))
        ));
        $flags = ['afterinput', 'numbers', 'grademethod', 'ignorecase', 'ignorespaces', 'hidetools', 'parsons', 'aihints',
            'ordercheck', 'strictinit'];
        foreach ($flags as $field) {
            $question->$field = (int) !empty($question->$field);
        }
        $most = \qtype_algorithm\local\parsons::MAX_DISTRACTORS;
        $question->distractors = max(0, min($most, (int) ($question->distractors ?? 0)));
        // A question is a Parsons problem or a fill-the-gaps problem, not both.
        $question->gaps = $question->parsons ? 0 : max(0, min(\qtype_algorithm\local\gaps::MAX_GAPS, (int) ($question->gaps ?? 0)));
        $question->tolerance = max(0.0, (float) ($question->tolerance ?? 0));
        $question->stepfactor = max(0.0, round((float) ($question->stepfactor ?? 0), 2));
        $question->maxgrowth = in_array($question->maxgrowth ?? '', growth::LIMITS, true) ? $question->maxgrowth : '';
        $question->maxblocks = max(0, (int) ($question->maxblocks ?? 0));
        $question->efficiencypenalty = max(0, min(100, (int) ($question->efficiencypenalty ?? 50)));
        $question->showtests = (int) ($question->showtests ?? 1);
        $computed = self::compute_tests(
            $question->solution,
            $question->tests ?? '',
            self::check_options($question),
            !empty($question->strictinit)
        );
        $question->tests = $computed['tests'] ? json_encode($computed['tests'], JSON_UNESCAPED_UNICODE) : '';
        $result = parent::save_question_options($question);
        $this->save_hints($question);
        return $result;
    }

    /**
     * Load the options; questions saved before the options existed get the defaults.
     *
     * @param stdClass $question question data
     * @return bool
     */
    public function get_question_options($question) {
        global $DB;
        if (!isset($question->options)) {
            $question->options = new stdClass();
        }
        $record = $DB->get_record('qtype_algorithm_options', ['questionid' => $question->id]);
        $defaults = ['solution' => '', 'template' => '', 'tests' => '', 'afterinput' => 0, 'numbers' => 0, 'structures' => '',
            'showtests' => 1, 'grademethod' => 0, 'ignorecase' => 0, 'ignorespaces' => 0, 'tolerance' => 0, 'hidetools' => 0,
            'parsons' => 0, 'distractors' => 0, 'stepfactor' => 0, 'maxgrowth' => '', 'maxblocks' => 0, 'efficiencypenalty' => 50,
            'aihints' => 0, 'gaps' => 0, 'ordercheck' => 0,
            'strictinit' => 0];
        foreach ($defaults as $field => $default) {
            $question->options->$field = $record && isset($record->$field) ? $record->$field : $default;
        }
        $question->options->answers = [];
        $question->hints = $DB->get_records('question_hints', ['questionid' => $question->id], 'id ASC');
        return true;
    }

    /**
     * Set up the question definition from the data.
     *
     * @param question_definition $question the question
     * @param stdClass $questiondata data from the database
     */
    protected function initialise_question_instance(question_definition $question, $questiondata) {
        parent::initialise_question_instance($question, $questiondata);
        $o = $questiondata->options ?? new stdClass();
        $question->solution = (string) ($o->solution ?? '');
        $question->template = (string) ($o->template ?? '');
        $tests = json_decode((string) ($o->tests ?? ''), true);
        $question->tests = is_array($tests) ? $tests : [];
        $question->afterinput = !empty($o->afterinput);
        $question->numbers = !empty($o->numbers);
        $question->structures = array_values(array_filter(explode(',', (string) ($o->structures ?? ''))));
        $question->showtests = !isset($o->showtests) || !empty($o->showtests);
        $question->grademethod = (int) ($o->grademethod ?? 0);
        $question->ignorecase = !empty($o->ignorecase);
        $question->ignorespaces = !empty($o->ignorespaces);
        $question->tolerance = max(0.0, (float) ($o->tolerance ?? 0));
        $question->hidetools = !empty($o->hidetools);
        $question->parsons = !empty($o->parsons);
        $question->distractors = (int) ($o->distractors ?? 0);
        $question->gaps = $question->parsons ? 0 : max(0, (int) ($o->gaps ?? 0));
        $question->ordercheck = $question->parsons && !empty($o->ordercheck);
        $question->strictinit = !empty($o->strictinit);
        $question->stepfactor = max(0.0, (float) ($o->stepfactor ?? 0));
        $question->maxgrowth = in_array($o->maxgrowth ?? '', growth::LIMITS, true) ? (string) $o->maxgrowth : '';
        $question->maxblocks = max(0, (int) ($o->maxblocks ?? 0));
        $question->efficiencypenalty = (int) ($o->efficiencypenalty ?? 50);
        $question->aihints = !empty($o->aihints);
    }

    /**
     * Export to Moodle XML.
     *
     * @param stdClass $question question data
     * @param qformat_xml $format the format
     * @param mixed $extra unused
     * @return string
     */
    public function export_to_xml($question, qformat_xml $format, $extra = null) {
        $fields = $this->extra_question_fields();
        array_shift($fields);
        $out = '';
        foreach ($fields as $field) {
            $out .= "    <{$field}>" . $format->xml_escape((string) ($question->options->$field ?? '')) . "</{$field}>\n";
        }
        return $out;
    }

    /**
     * Import from Moodle XML.
     *
     * @param array $data parsed XML
     * @param stdClass $question unused
     * @param qformat_xml $format the format
     * @param mixed $extra unused
     * @return stdClass|false
     */
    public function import_from_xml($data, $question, qformat_xml $format, $extra = null) {
        if (($data['@']['type'] ?? '') !== $this->name()) {
            return false;
        }
        $qo = $format->import_headers($data);
        $qo->qtype = $this->name();
        $fields = $this->extra_question_fields();
        array_shift($fields);
        $defaults = ['showtests' => 1, 'ignorecase' => 0, 'ignorespaces' => 0, 'tolerance' => 0, 'hidetools' => 0,
            'parsons' => 0, 'distractors' => 0, 'stepfactor' => 0, 'maxgrowth' => '', 'maxblocks' => 0, 'efficiencypenalty' => 50,
            'aihints' => 0, 'gaps' => 0, 'ordercheck' => 0,
            'strictinit' => 0];
        foreach ($fields as $field) {
            $qo->$field = $format->getpath($data, ['#', $field, 0, '#'], $defaults[$field] ?? '');
        }
        $format->import_hints($qo, $data, false, false, $format->get_format($qo->questiontextformat));
        return $qo;
    }
}
