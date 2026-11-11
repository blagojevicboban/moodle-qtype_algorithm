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
 * Algorithm question definition class.
 *
 * @package    qtype_algorithm
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use qtype_algorithm\local\tester;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/question/type/questionbase.php');

/**
 * Represents an Algorithm question. The response is the algorithm model (base64 encoded JSON) produced by tiny_algorithm.
 *
 * @package    qtype_algorithm
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_algorithm_question extends question_graded_automatically {
    /** @var string the teacher's algorithm (base64 encoded JSON) */
    public $solution = '';

    /** @var string algorithm the students start from (base64 encoded JSON), '' for an empty diagram */
    public $template = '';

    /** @var array tests: inputs, hidden, weight, call (a function test), expected */
    public $tests = [];

    /** @var bool compare only the output after the last input */
    public $afterinput = false;

    /** @var bool compare only the numbers in the output */
    public $numbers = false;

    /** @var array structures the algorithm must use (if, for, while, dowhile, array, matrix) */
    public $structures = [];

    /** @var bool students may run the tests that are not hidden during the attempt */
    public $showtests = true;

    /** @var int 0: share of passed tests (by weight), 1: all tests must pass */
    public $grademethod = 0;

    /** @var bool capital and small letters are the same in the comparison */
    public $ignorecase = false;

    /** @var bool extra spaces do not count in the comparison */
    public $ignorespaces = false;

    /** @var float numbers may differ by this much */
    public $tolerance = 0.0;

    /** @var bool hide the generated code and the file import and export from students */
    public $hidetools = false;

    /** @var bool a Parsons problem: students arrange the blocks of the solution */
    public $parsons = false;

    /** @var int extra wrong blocks of a Parsons problem */
    public $distractors = 0;

    /** @var array results by response, so that grading and feedback run the tests once */
    protected $resultcache = [];

    /** @var array the last decoded response: its text, the model and the number of blocks */
    protected $decoded = ['answer' => null, 'model' => null, 'blocks' => 0];

    /** Longest stored response (base64 encoded JSON) that is decoded. */
    const MAX_ANSWER_LENGTH = 500000;

    /** Most blocks a response may have. */
    const MAX_BLOCKS = 2000;

    /** Deepest JSON nesting of a response (blocks inside loops and branches). */
    const MAX_DEPTH = 64;

    /**
     * Code languages for the views of this question: the site and the course, and the language of the question (chosen
     * with its solution), which comes before the course unless the course forces its own.
     *
     * @param \context $context where the question is shown
     * @return array as tiny_algorithm\local\code_language::for_context
     */
    public function code_config(\context $context): array {
        $config = \tiny_algorithm\local\code_language::for_context($context);
        $solution = self::decode_answer($this->solution);
        $lang = is_array($solution) ? (string) ($solution['codeLang'] ?? '') : '';
        if (!$config['force'] && in_array($lang, $config['allowed'], true)) {
            $config['default'] = $lang;
            $config['force'] = true;
            $config['lock'] = $config['lock'] || !empty($solution['codeLock']);
        }
        return $config;
    }

    /**
     * A Parsons problem gets its blocks in a random order when the attempt starts; the order is kept in the attempt.
     *
     * @param question_attempt_step $step the first step of the attempt
     * @param int $variant unused
     */
    public function start_attempt(question_attempt_step $step, $variant) {
        if ($this->parsons) {
            $seed = random_int(1, 2147483646);
            $step->set_qt_var('_parsons', \qtype_algorithm\local\parsons::build($this->solution, $this->distractors, $seed));
        }
    }

    /**
     * The algorithm a student starts from: the blocks of a Parsons problem, else the template.
     *
     * @param question_attempt $qa the attempt
     * @return string base64 encoded JSON, '' for an empty diagram
     */
    public function start_program(question_attempt $qa): string {
        if ($this->parsons) {
            $start = (string) $qa->get_step(0)->get_qt_var('_parsons');
            if ($start !== '') {
                return $start;
            }
            // An attempt started before the question became a Parsons problem.
            $seed = (int) $qa->get_database_id();
            return \qtype_algorithm\local\parsons::build($this->solution, $this->distractors, $seed);
        }
        return $this->template;
    }

    /**
     * Is the question graded automatically (it has a solution and tests)?
     *
     * @return bool
     */
    public function has_tests(): bool {
        return $this->tests && self::decode_answer($this->solution) !== null;
    }

    /**
     * Questions with tests use the quiz behaviour, the others are graded manually.
     *
     * @param question_attempt $qa the attempt
     * @param string $preferredbehaviour the quiz behaviour
     * @return question_behaviour
     */
    public function make_behaviour(question_attempt $qa, $preferredbehaviour) {
        if (!$this->has_tests()) {
            return question_engine::make_behaviour('manualgraded', $qa, $preferredbehaviour);
        }
        return parent::make_behaviour($qa, $preferredbehaviour);
    }

    /**
     * What is compared in the tests.
     *
     * @return array
     */
    public function check_options(): array {
        return ['afterinput' => (bool) $this->afterinput, 'numbers' => (bool) $this->numbers,
            'ignorecase' => (bool) $this->ignorecase, 'ignorespaces' => (bool) $this->ignorespaces,
            'tolerance' => (float) $this->tolerance];
    }

    /**
     * Required structures the response does not use.
     *
     * @param array $response the response
     * @return string[]
     */
    public function missing_structures(array $response): array {
        $model = $this->decode_response($response);
        return array_values(array_diff($this->structures, $model ? tester::structures($model) : []));
    }

    /**
     * Run the tests against a response.
     *
     * @param array $response the response
     * @return array results of tester::run_tests, empty when the response is not an algorithm
     */
    public function test_results(array $response): array {
        $answer = (string) ($response['answer'] ?? '');
        if (!array_key_exists($answer, $this->resultcache)) {
            $model = $this->is_too_large($response) ? null : $this->decode_response($response);
            $this->resultcache[$answer] = $model ? $this->cached_results($model, $answer) : [];
        }
        return $this->resultcache[$answer];
    }

    /**
     * Test results from the cache, or from running the tests (the review of an attempt then does not run them again).
     *
     * @param array $model the decoded response
     * @param string $answer the response as stored
     * @return array results of tester::run_tests
     */
    protected function cached_results(array $model, string $answer): array {
        $cache = \cache::make('qtype_algorithm', 'results');
        // The messages are in the user's language, and a new version of the plugin may give other results.
        // The tests read the files of the question (its solution), not files a student changed in the answer.
        $solution = self::decode_answer($this->solution);
        $files = is_array($solution['files'] ?? null) ? $solution['files'] : [];
        $model['files'] = $files;
        $key = sha1(json_encode([get_config('qtype_algorithm', 'version'), current_language(), $this->tests,
            $this->check_options(), $files, $answer]));
        $results = $cache->get($key);
        if (!is_array($results)) {
            $results = tester::run_tests($model, $this->tests, $this->check_options(), get_string('noinput', 'qtype_algorithm'));
            $cache->set($key, $results);
        }
        return $results;
    }

    /**
     * Weight of a test in the grade (1 when the teacher did not set one).
     *
     * @param array $tc test
     * @return float
     */
    public static function test_weight(array $tc): float {
        return isset($tc['weight']) && is_numeric($tc['weight']) && $tc['weight'] >= 0 ? (float) $tc['weight'] : 1.0;
    }

    /**
     * Grade: the share of passed tests by their weight (or all or nothing); 0 when a required structure is missing.
     *
     * @param array $response the response
     * @return array [fraction, state]
     */
    public function grade_response(array $response) {
        $results = $this->test_results($response);
        $passed = 0;
        $weight = 0.0;
        $total = 0.0;
        foreach (array_values($this->tests) as $i => $tc) {
            $total += self::test_weight($tc);
            if (!empty($results[$i]['pass'])) {
                $passed++;
                $weight += self::test_weight($tc);
            }
        }
        $fraction = $total > 0 ? $weight / $total : 0;
        if ($this->grademethod && $passed < count($this->tests)) {
            $fraction = 0;
        }
        if ($this->missing_structures($response)) {
            $fraction = 0;
        }
        return [$fraction, question_state::graded_state_for_fraction($fraction)];
    }

    /**
     * For the response analysis of the quiz statistics: whether the response passed every test.
     *
     * @param array $response the response
     * @return array test index => question_classified_response
     */
    public function classify_response(array $response) {
        if (!$this->has_tests()) {
            return [];
        }
        $results = $this->is_gradable_response($response) ? $this->test_results($response) : [];
        $parts = [];
        foreach (array_keys(array_values($this->tests)) as $i) {
            if (!isset($results[$i])) {
                $parts[$i] = question_classified_response::no_response();
            } else if ($results[$i]['pass']) {
                $parts[$i] = new question_classified_response('pass', get_string('testpassed', 'qtype_algorithm', $i + 1), 1);
            } else if ($results[$i]['error'] !== null) {
                $parts[$i] = new question_classified_response('error', get_string('testerror', 'qtype_algorithm', $i + 1), 0);
            } else {
                $parts[$i] = new question_classified_response('fail', get_string('testfailed', 'qtype_algorithm', $i + 1), 0);
            }
        }
        return $parts;
    }

    /**
     * The only response variable is the encoded algorithm.
     *
     * @return array
     */
    public function get_expected_data() {
        return ['answer' => PARAM_RAW];
    }

    /**
     * Decode a stored response into the algorithm model.
     *
     * @param string $answer base64 encoded JSON
     * @return array|null the model, or null when it is empty or invalid
     */
    public static function decode_answer(string $answer): ?array {
        if ($answer === '' || strlen($answer) > self::MAX_ANSWER_LENGTH) {
            return null;
        }
        $json = base64_decode($answer, true);
        $model = $json === false ? null : json_decode($json, true, self::MAX_DEPTH);
        if (!is_array($model) || empty($model['functions']) || !is_array($model['functions'])) {
            return null;
        }
        return $model;
    }

    /**
     * Count the blocks of a statement list, including nested ones.
     *
     * @param array $list list of blocks
     * @return int
     */
    protected static function count_blocks(array $list): int {
        $count = 0;
        foreach ($list as $block) {
            if (!is_array($block)) {
                continue;
            }
            $count++;
            foreach (['then', 'else', 'body'] as $child) {
                if (!empty($block[$child]) && is_array($block[$child])) {
                    $count += self::count_blocks($block[$child]);
                }
            }
        }
        return $count;
    }

    /**
     * Number of blocks in a response.
     *
     * @param array $response the response
     * @return int
     */
    protected function blocks_in_response(array $response): int {
        $this->decode_response($response);
        return $this->decoded['blocks'];
    }

    /**
     * Decode a response once: the question asks for the model and the number of blocks many times in a request.
     *
     * @param array $response the response
     * @return array|null the model, or null when it is empty or invalid
     */
    protected function decode_response(array $response): ?array {
        $answer = (string) ($response['answer'] ?? '');
        if ($this->decoded['answer'] !== $answer) {
            $model = self::decode_answer($answer);
            $count = 0;
            foreach ($model['functions'] ?? [] as $function) {
                $count += is_array($function) ? self::count_blocks($function['body'] ?? []) : 0;
            }
            $this->decoded = ['answer' => $answer, 'model' => $model, 'blocks' => $count];
        }
        return $this->decoded['model'];
    }

    /**
     * Short text summary of the response, used in reports.
     *
     * @param array $response the response
     * @return string|null
     */
    public function summarise_response(array $response) {
        $model = $this->decode_response($response);
        if (!$model) {
            return null;
        }
        return get_string('responsesummary', 'qtype_algorithm', (object) [
            'blocks' => $this->blocks_in_response($response),
            'functions' => count($model['functions']),
        ]);
    }

    /**
     * A summary cannot be turned back into a response.
     *
     * @param string $summary the summary
     * @return array
     */
    public function un_summarise_response(string $summary) {
        return [];
    }

    /**
     * The teacher's solution, when there is one.
     *
     * @return array|null
     */
    public function get_correct_response() {
        return self::decode_answer($this->solution) ? ['answer' => $this->solution] : null;
    }

    /**
     * A response is complete when the diagram has at least one block and is not too large.
     *
     * @param array $response the response
     * @return bool
     */
    public function is_complete_response(array $response) {
        return $this->blocks_in_response($response) > 0 && !$this->is_too_large($response);
    }

    /**
     * Is the response larger than the question type accepts?
     *
     * @param array $response the response
     * @return bool
     */
    public function is_too_large(array $response): bool {
        return strlen((string) ($response['answer'] ?? '')) > self::MAX_ANSWER_LENGTH ||
            $this->blocks_in_response($response) > self::MAX_BLOCKS;
    }

    /**
     * The same rule decides whether a response can be graded.
     *
     * @param array $response the response
     * @return bool
     */
    public function is_gradable_response(array $response) {
        return $this->is_complete_response($response);
    }

    /**
     * Message shown when the response is not complete.
     *
     * @param array $response the response
     * @return string
     */
    public function get_validation_error(array $response) {
        if ($this->is_too_large($response)) {
            return get_string('toolarge', 'qtype_algorithm', self::MAX_BLOCKS);
        }
        return $this->is_complete_response($response) ? '' : get_string('pleasedrawalgorithm', 'qtype_algorithm');
    }

    /**
     * Two responses are the same when the encoded algorithms are equal.
     *
     * @param array $prevresponse the previous response
     * @param array $newresponse the new response
     * @return bool
     */
    public function is_same_response(array $prevresponse, array $newresponse) {
        return question_utils::arrays_same_at_key_missing_is_blank($prevresponse, $newresponse, 'answer');
    }
}
