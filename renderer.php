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

        $this->page->requires->js_call_amd('qtype_algorithm/attempt', 'init', [
            $containerid, $inputname, (bool) $options->readonly, current_language(),
            get_string('noalgorithm', 'qtype_algorithm'),
        ]);
        return $result;
    }
}
