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

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/question/type/questionbase.php');

/**
 * Represents an Algorithm question. The response is the algorithm model (base64 encoded JSON) produced by tiny_algorithm.
 *
 * @package    qtype_algorithm
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_algorithm_question extends question_with_responses {
    /**
     * Use the manual grading behaviour.
     *
     * @param question_attempt $qa the attempt
     * @param string $preferredbehaviour the quiz behaviour
     * @return question_behaviour
     */
    public function make_behaviour(question_attempt $qa, $preferredbehaviour) {
        return question_engine::make_behaviour('manualgraded', $qa, $preferredbehaviour);
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
        if ($answer === '') {
            return null;
        }
        $json = base64_decode($answer, true);
        $model = $json === false ? null : json_decode($json, true);
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
        $model = self::decode_answer((string) ($response['answer'] ?? ''));
        $count = 0;
        foreach ($model['functions'] ?? [] as $function) {
            $count += self::count_blocks($function['body'] ?? []);
        }
        return $count;
    }

    /**
     * Short text summary of the response, used in reports.
     *
     * @param array $response the response
     * @return string|null
     */
    public function summarise_response(array $response) {
        $model = self::decode_answer((string) ($response['answer'] ?? ''));
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
     * There is no single correct response.
     *
     * @return null
     */
    public function get_correct_response() {
        return null;
    }

    /**
     * A response is complete when the diagram has at least one block.
     *
     * @param array $response the response
     * @return bool
     */
    public function is_complete_response(array $response) {
        return $this->blocks_in_response($response) > 0;
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
