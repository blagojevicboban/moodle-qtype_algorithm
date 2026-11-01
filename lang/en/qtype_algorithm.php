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
 * Strings for the Algorithm question type.
 *
 * @package    qtype_algorithm
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['afterinput'] = 'Only the output after the last input';
$string['compare'] = 'What is compared';
$string['copyfromsolution'] = 'Copy from the solution';
$string['correctsolution'] = 'The teacher\'s solution:';
$string['emptytemplate'] = 'Empty';
$string['expected'] = 'Expected';
$string['failed'] = 'Failed';
$string['got'] = 'Your output';
$string['grademethod'] = 'Grade';
$string['grademethod_all'] = 'Full marks only when all tests pass';
$string['grademethod_proportional'] = 'Share of passed tests';
$string['gradingnote'] = 'With tests, the answer is graded automatically: the algorithm runs on the inputs of every test and its output is compared with the output of your solution. Without tests, you grade the answer manually.';
$string['hiddentest'] = 'Hidden test';
$string['inputs'] = 'Input';
$string['missingstructures'] = 'The algorithm must use: {$a}. The answer gets no marks.';
$string['noalgorithm'] = 'No algorithm was submitted.';
$string['noinput'] = 'The algorithm asks for more input than the test provides.';
$string['nosolution'] = 'Draw the solution: the expected outputs of the tests are computed from it.';
$string['numbers'] = 'Only the numbers (text around them may be anything)';
$string['numbers_help'] = 'Only the numbers in the output are compared, in order, so students can write any text around them. With "Only the output after the last input", prompts such as "Enter a number" do not count either.';
$string['passed'] = 'Passed';
$string['pleasedrawalgorithm'] = 'Please draw an algorithm: add at least one block.';
$string['pluginname'] = 'Algorithm';
$string['pluginname_help'] = 'The student draws an algorithm as a flowchart in the question and can run it. With tests, the answer is graded automatically; without tests, the teacher grades it.';
$string['pluginnameadding'] = 'Adding an Algorithm question';
$string['pluginnameediting'] = 'Editing an Algorithm question';
$string['pluginnamesummary'] = 'The student draws an algorithm as a flowchart and can run it. Graded automatically with tests computed from the teacher\'s solution, or manually.';
$string['privacy:metadata'] = 'The Algorithm question type does not store any personal data. Answers are stored by the Moodle question engine. The browser keeps a few display settings (code and variables shown or hidden) in its local storage.';
$string['responsesummary'] = 'Algorithm with {$a->blocks} block(s) in {$a->functions} function(s)';
$string['rule_numbers'] = 'The tests compare only the numbers your algorithm writes, in order.';
$string['rule_numbersafter'] = 'The tests compare only the numbers your algorithm writes after the last input, in order; the text around them may be anything.';
$string['rule_structures'] = 'The algorithm must use: {$a}.';
$string['rule_text'] = 'The tests compare everything your algorithm writes.';
$string['rule_textafter'] = 'The tests compare what your algorithm writes after the last input.';
$string['showtests'] = 'Tests in the attempt';
$string['showtests_desc'] = 'Students can run the tests that are not hidden while they work';
$string['solution'] = 'Solution';
$string['solutionandtests'] = 'Solution and tests';
$string['solutionfails'] = 'The solution fails on test {$a->n}: {$a->error}';
$string['structure_array'] = 'array';
$string['structure_dowhile'] = 'Do loop';
$string['structure_for'] = 'For loop';
$string['structure_if'] = 'If';
$string['structure_while'] = 'While loop';
$string['structures'] = 'Required structures';
$string['structures_help'] = 'If the answer does not use every structure ticked here, it gets no marks, even when the tests pass.';
$string['template'] = 'Starting template';
$string['test'] = 'Test';
$string['tests'] = 'Tests';
$string['tests_help'] = 'Add tests and type their inputs, one value per line ("" for an empty value). The expected outputs are computed from your solution when the question is saved. Hidden tests are graded but students do not see their inputs and outputs.';
$string['testssummary'] = 'Tests passed: {$a->passed} of {$a->total}';
$string['toolarge'] = 'The algorithm is too large: it may have at most {$a} blocks.';
$string['usetemplate'] = 'Students start from a separate template instead of an empty diagram';
