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
 * Defines the editing form for the Algorithm question type.
 *
 * @package    qtype_algorithm
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Algorithm question editing form: the solution, an optional starting template, the tests and how they are graded.
 *
 * @package    qtype_algorithm
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_algorithm_edit_form extends question_edit_form {
    /**
     * Add question-type specific form fields.
     *
     * @param MoodleQuickForm $mform the form being built
     */
    protected function definition_inner($mform) {
        $mform->addElement('header', 'algorithmheader', get_string('solutionandtests', 'qtype_algorithm'));
        $mform->setExpanded('algorithmheader');
        $mform->addElement('static', 'gradingnote', '', get_string('gradingnote', 'qtype_algorithm'));

        $mform->addElement(
            'static',
            'solutionarea',
            get_string('solution', 'qtype_algorithm'),
            html_writer::div('', 'qtype_algorithm_editor', ['id' => 'qtype_algorithm_solution'])
        );
        $mform->addElement('hidden', 'solution', '');
        $mform->setType('solution', PARAM_RAW);

        $mform->addElement(
            'advcheckbox',
            'usetemplate',
            get_string('template', 'qtype_algorithm'),
            get_string('usetemplate', 'qtype_algorithm')
        );
        $mform->addElement('static', 'templatearea', '', html_writer::div(
            '',
            'qtype_algorithm_template',
            ['id' => 'qtype_algorithm_template']
        ));
        $mform->addElement('hidden', 'template', '');
        $mform->setType('template', PARAM_RAW);

        $mform->addElement(
            'static',
            'testsarea',
            get_string('tests', 'qtype_algorithm'),
            html_writer::div('', '', ['id' => 'qtype_algorithm_tests'])
        );
        $mform->addHelpButton('testsarea', 'tests', 'qtype_algorithm');
        $mform->addElement('hidden', 'tests', '');
        $mform->setType('tests', PARAM_RAW);

        $mform->addElement(
            'advcheckbox',
            'afterinput',
            get_string('compare', 'qtype_algorithm'),
            get_string('afterinput', 'qtype_algorithm')
        );
        $mform->addElement('advcheckbox', 'numbers', '', get_string('numbers', 'qtype_algorithm'));
        $mform->addHelpButton('numbers', 'numbers', 'qtype_algorithm');
        $mform->addElement('advcheckbox', 'ignorecase', '', get_string('ignorecase', 'qtype_algorithm'));
        $mform->addElement('advcheckbox', 'ignorespaces', '', get_string('ignorespaces', 'qtype_algorithm'));
        $mform->addElement('text', 'tolerance', get_string('tolerance', 'qtype_algorithm'), ['size' => 8]);
        $mform->setType('tolerance', PARAM_FLOAT);
        $mform->setDefault('tolerance', 0);
        $mform->addHelpButton('tolerance', 'tolerance', 'qtype_algorithm');

        $structures = [];
        foreach (qtype_algorithm::STRUCTURES as $s) {
            $structures[] = $mform->createElement('advcheckbox', $s, '', get_string('structure_' . $s, 'qtype_algorithm'));
        }
        $mform->addGroup($structures, 'structures', get_string('structures', 'qtype_algorithm'), ' ', true);
        $mform->addHelpButton('structures', 'structures', 'qtype_algorithm');

        $mform->addElement('select', 'grademethod', get_string('grademethod', 'qtype_algorithm'), [
            0 => get_string('grademethod_proportional', 'qtype_algorithm'),
            1 => get_string('grademethod_all', 'qtype_algorithm'),
        ]);
        $mform->addElement(
            'advcheckbox',
            'showtests',
            get_string('showtests', 'qtype_algorithm'),
            get_string('showtests_desc', 'qtype_algorithm')
        );
        $mform->setDefault('showtests', 1);
        $mform->addElement(
            'advcheckbox',
            'hidetools',
            get_string('studenteditor', 'qtype_algorithm'),
            get_string('hidetools', 'qtype_algorithm')
        );
        $mform->addHelpButton('hidetools', 'hidetools', 'qtype_algorithm');

        // Hints and penalty for the interactive behaviour with several tries.
        $this->add_interactive_settings();

        global $PAGE;
        $PAGE->requires->js_call_amd('qtype_algorithm/edit', 'init', [current_language(),
            \tiny_algorithm\local\code_language::for_context($this->context)]);
    }

    /**
     * Put the stored options into the form.
     *
     * @param stdClass $question question data
     * @return stdClass
     */
    protected function data_preprocessing($question) {
        $question = parent::data_preprocessing($question);
        $o = $question->options ?? null;
        if ($o) {
            $question->solution = $o->solution ?? '';
            $question->template = $o->template ?? '';
            $question->usetemplate = (int) ($question->template !== '');
            $question->tests = $o->tests ?? '';
            $question->afterinput = $o->afterinput ?? 0;
            $question->numbers = $o->numbers ?? 0;
            $question->showtests = $o->showtests ?? 1;
            $question->grademethod = $o->grademethod ?? 0;
            $question->ignorecase = $o->ignorecase ?? 0;
            $question->ignorespaces = $o->ignorespaces ?? 0;
            $question->tolerance = (float) ($o->tolerance ?? 0);
            $question->hidetools = $o->hidetools ?? 0;
            $question->structures = array_fill_keys(array_filter(explode(',', (string) ($o->structures ?? ''))), 1);
        }
        return $this->data_preprocessing_hints($question);
    }

    /**
     * The solution must be an algorithm and must run on every test.
     *
     * @param array $data form data
     * @param array $files uploaded files
     * @return array errors
     */
    public function validation($data, $files) {
        $errors = parent::validation($data, $files);
        if ((float) ($data['tolerance'] ?? 0) < 0) {
            $errors['tolerance'] = get_string('tolerancenegative', 'qtype_algorithm');
        }
        $tests = json_decode((string) ($data['tests'] ?? ''), true);
        if (!is_array($tests) || !$tests) {
            return $errors;
        }
        if (!qtype_algorithm_question::decode_answer((string) ($data['solution'] ?? ''))) {
            $errors['solutionarea'] = get_string('nosolution', 'qtype_algorithm');
            return $errors;
        }
        $computed = qtype_algorithm::compute_tests($data['solution'], $tests, qtype_algorithm::check_options((object) $data));
        $messages = [];
        foreach ($computed['errors'] as $e) {
            $messages[] = get_string('solutionfails', 'qtype_algorithm', (object) ['n' => $e['index'] + 1, 'error' => $e['error']]);
        }
        if ($messages) {
            $errors['testsarea'] = implode('<br>', array_map('s', $messages));
        }
        return $errors;
    }

    /**
     * The question type name.
     *
     * @return string
     */
    public function qtype() {
        return 'algorithm';
    }
}
