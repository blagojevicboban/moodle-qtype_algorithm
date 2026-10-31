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
 * Algorithm question renderer.
 *
 * @package    qtype_algorithm
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use qtype_algorithm\local\tester;

/**
 * Renders the question text and the flowchart editor (or, when review is read-only, the runnable diagram).
 *
 * @package    qtype_algorithm
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_algorithm_renderer extends qtype_renderer {
    /**
     * Generate the display of the question formulation and the response controls.
     *
     * @param question_attempt $qa the attempt
     * @param question_display_options $options display options
     * @return string HTML
     */
    public function formulation_and_controls(question_attempt $qa, question_display_options $options) {
        $question = $qa->get_question();
        $inputname = $qa->get_qt_field_name('answer');
        $answer = (string) $qa->get_last_qt_var('answer', '');
        $containerid = $inputname . '_algorithm';

        $result = html_writer::tag('div', $question->format_questiontext($qa), ['class' => 'qtext']);
        if ($question->has_tests()) {
            $result .= $this->rules($question);
        }
        $result .= html_writer::empty_tag('input', [
            'type' => 'hidden', 'name' => $inputname, 'id' => $inputname, 'value' => $answer,
        ]);
        $result .= html_writer::tag('div', '', ['id' => $containerid, 'class' => 'qtype_algorithm_container']);

        if ($qa->get_state() == question_state::$invalid) {
            $result .= html_writer::nonempty_tag(
                'div',
                $question->get_validation_error(['answer' => $answer]),
                ['class' => 'validationerror']
            );
        }

        // Only the tests that are not hidden reach the browser.
        $tests = [];
        if ($question->has_tests() && $question->showtests) {
            foreach ($question->tests as $tc) {
                if (empty($tc['hidden'])) {
                    $tests[] = ['inputs' => (string) $tc['inputs'], 'expected' => (string) ($tc['expected'] ?? '')];
                }
            }
        }
        $this->page->requires->js_call_amd('qtype_algorithm/attempt', 'init', [
            $containerid, $inputname, (bool) $options->readonly, current_language(),
            get_string('noalgorithm', 'qtype_algorithm'),
            ['template' => $question->template, 'tests' => $tests, 'check' => $question->check_options()],
        ]);
        return $result;
    }

    /**
     * How the algorithm is checked: what is compared and which structures it must use.
     *
     * @param qtype_algorithm_question $question the question
     * @return string HTML
     */
    protected function rules(qtype_algorithm_question $question): string {
        $items = [get_string($question->numbers ? ($question->afterinput ? 'rule_numbersafter' : 'rule_numbers') :
            ($question->afterinput ? 'rule_textafter' : 'rule_text'), 'qtype_algorithm')];
        if ($question->structures) {
            $names = array_map(fn($s) => get_string('structure_' . $s, 'qtype_algorithm'), $question->structures);
            $items[] = get_string('rule_structures', 'qtype_algorithm', implode(', ', $names));
        }
        return html_writer::alist($items, ['class' => 'qtype_algorithm_rules']);
    }

    /**
     * Result of every test for the response (hidden tests show only whether they passed).
     *
     * @param question_attempt $qa the attempt
     * @return string HTML
     */
    public function specific_feedback(question_attempt $qa) {
        $question = $qa->get_question();
        if (!$question->has_tests()) {
            return '';
        }
        $response = $qa->get_last_qt_data();
        if (!$question->is_gradable_response($response)) {
            return '';
        }
        $out = '';
        $missing = $question->missing_structures($response);
        if ($missing) {
            $names = array_map(fn($s) => get_string('structure_' . $s, 'qtype_algorithm'), $missing);
            $out .= html_writer::div(get_string('missingstructures', 'qtype_algorithm', implode(', ', $names)),
                'alert alert-warning');
        }
        $results = $question->test_results($response);
        $table = new html_table();
        $table->attributes['class'] = 'generaltable qtype_algorithm_results';
        $table->head = [get_string('test', 'qtype_algorithm'), get_string('inputs', 'qtype_algorithm'),
            get_string('expected', 'qtype_algorithm'), get_string('got', 'qtype_algorithm'), ''];
        $pre = fn($text) => html_writer::tag('pre', s($text), ['class' => 'mb-0']);
        foreach ($question->tests as $i => $tc) {
            $r = $results[$i] ?? ['pass' => false, 'actual' => '', 'error' => null];
            $mark = $r['pass'] ? $this->output->pix_icon('i/valid', get_string('passed', 'qtype_algorithm')) :
                $this->output->pix_icon('i/invalid', get_string('failed', 'qtype_algorithm'));
            if (!empty($tc['hidden'])) {
                $cells = [$i + 1, html_writer::span(get_string('hiddentest', 'qtype_algorithm'), 'text-muted'), '', '', $mark];
            } else {
                $got = $pre($r['actual']);
                if ($r['error']) {
                    $got .= html_writer::div(s($r['error']), 'text-danger');
                }
                $inputs = implode(', ', tester::parse_inputs($tc['inputs']));
                $cells = [$i + 1, $pre($inputs), $pre($tc['expected'] ?? ''), $got, $mark];
            }
            $row = new html_table_row($cells);
            $row->attributes['class'] = $r['pass'] ? 'qtype_algorithm_pass' : 'qtype_algorithm_fail';
            $table->data[] = $row;
        }
        $passed = count(array_filter($results, fn($r) => $r['pass']));
        $out .= html_writer::div(get_string('testssummary', 'qtype_algorithm',
            (object) ['passed' => $passed, 'total' => count($question->tests)]), 'mb-2');
        return $out . html_writer::table($table);
    }

    /**
     * The teacher's solution as a runnable diagram.
     *
     * @param question_attempt $qa the attempt
     * @return string HTML
     */
    public function correct_response(question_attempt $qa) {
        $question = $qa->get_question();
        if (!$question->get_correct_response()) {
            return '';
        }
        $id = $qa->get_qt_field_name('solution');
        $this->page->requires->js_call_amd('qtype_algorithm/attempt', 'showSolution', [$id, $question->solution,
            current_language()]);
        return html_writer::div(get_string('correctsolution', 'qtype_algorithm'), 'mb-1') .
            html_writer::div('', 'qtype_algorithm_container', ['id' => $id]);
    }
}
