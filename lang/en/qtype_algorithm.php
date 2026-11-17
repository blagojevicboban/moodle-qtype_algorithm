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
$string['aihints'] = 'AI hints';
$string['aihints_desc'] = 'Students may ask the AI of the site for hints about errors and failed tests';
$string['aihints_help'] = 'With AI hints on in the settings of the Algorithm editor plugin and an AI provider of the site, students get the buttons Explain with AI (after an error) and Hint from AI (beside a failed test) in the attempt. The AI gets the student\'s algorithm as pseudo-code, the error or the visible test and the question text, and is told never to give the solution. Leave it off in exams.';
$string['answerlegend'] = 'Your algorithm';
$string['cachedef_results'] = 'Test results of algorithm responses';
$string['compare'] = 'What is compared';
$string['copyfromsolution'] = 'Copy from the solution';
$string['correctsolution'] = 'The teacher\'s solution:';
$string['distractors'] = 'Extra wrong blocks';
$string['distractors_help'] = 'Blocks made from blocks of the solution with a small mistake (< instead of <=, - 1 instead of + 1, or instead of and, a number one bigger). Students must leave them out.';
$string['efficiency'] = 'Efficiency';
$string['efficiency_blocks'] = 'The algorithm has {$a->blocks} blocks; at most {$a->max} are allowed.';
$string['efficiency_growth'] = 'The steps of the algorithm grow like {$a->growth}; at most {$a->max} is allowed.';
$string['efficiency_growthunknown'] = 'The growth of the algorithm could not be measured: it needs a size n (an Assign such as n = 10, or the first Input) and must run for n = 10, 20 and 50.';
$string['efficiency_steps'] = 'Test {$a->n}: the algorithm took {$a->steps} steps; at most {$a->max} are allowed.';
$string['efficiencypenalty'] = 'Penalty for an answer that is not efficient enough (%)';
$string['efficiencypenalty_help'] = 'When the answer passes tests but breaks a condition of efficiency (steps, growth or blocks), this percent is taken from its grade. 100 gives no marks to such an answer, 0 only shows the message.';
$string['efficiencypenaltyapplied'] = 'Because of this, {$a} % is taken from the grade.';
$string['efficiencypenaltyrange'] = 'The penalty is a percent from 0 to 100.';
$string['emptytemplate'] = 'Empty';
$string['expected'] = 'Expected';
$string['failed'] = 'Failed';
$string['got'] = 'Your output';
$string['grademethod'] = 'Grade';
$string['grademethod_all'] = 'Full marks only when all tests pass';
$string['grademethod_proportional'] = 'Share of passed tests, by their weight';
$string['gradingnote'] = 'With tests, the answer is graded automatically: the algorithm runs on the inputs of every test and its output is compared with the output of your solution. Without tests, you grade the answer manually.';
$string['growth_o1'] = '1 (constant)';
$string['growth_ologn'] = 'log n';
$string['growth_on'] = 'n (linear)';
$string['growth_on2'] = 'n² (quadratic)';
$string['growth_on3'] = 'n³ (cubic)';
$string['growth_onlogn'] = 'n log n';
$string['hiddentest'] = 'Hidden test';
$string['hidetools'] = 'Hide the generated code and the file import and export';
$string['hidetools_help'] = 'Students do not see the code panel, the .fprg import and export or the image buttons in the editor of the attempt. This discourages copying code from the diagram (or a diagram from a file); it does not lock anything. The review after the attempt shows the code as usual.';
$string['ignorecase'] = 'Capital and small letters are the same';
$string['ignorespaces'] = 'Extra spaces do not count';
$string['inputs'] = 'Input';
$string['maxblocks'] = 'Most blocks';
$string['maxblocks_help'] = 'The answer may have at most this many blocks in all its functions (0: no limit). A short solution is often a clearer one.';
$string['maxblocksnegative'] = 'The number of blocks cannot be negative.';
$string['maxgrowth'] = 'Steps may grow at most like';
$string['maxgrowth_help'] = 'The answer runs for n = 10, 20, 50, 100, 200 and 500, its steps are counted, and the growth that fits them best must not be faster than the one chosen here (Complexity in the editor measures the same way). The size n is an Assign of a whole number such as n = 10 in the main function, or else the first value the algorithm reads; the other values it reads are random whole numbers.';
$string['maxgrowth_none'] = 'No limit';
$string['missingstructures'] = 'The algorithm must use: {$a}. The answer gets no marks.';
$string['noalgorithm'] = 'No algorithm was submitted.';
$string['noinput'] = 'The algorithm asks for more input than the test provides.';
$string['nosolution'] = 'Draw the solution: the expected outputs of the tests are computed from it.';
$string['numbers'] = 'Only the numbers (text around them may be anything)';
$string['numbers_help'] = 'Only the numbers in the output are compared, in order, so students can write any text around them. With "Only the output after the last input", prompts such as "Enter a number" do not count either.';
$string['parsons'] = 'Parsons problem';
$string['parsons_desc'] = 'Students get the blocks of the solution in a random order and arrange them';
$string['parsons_help'] = 'Students do not draw the algorithm: they get every block of the solution, in a random order, with loops and branches empty, and move the blocks to their places. They cannot add blocks or change their text. The answer is graded with the tests, like any other. The starting template is not used.';
$string['parsonsintro'] = 'Arrange the given blocks: move each block to its place (also into loops and branches) and delete the blocks that do not belong.';
$string['passed'] = 'Passed';
$string['pleasedrawalgorithm'] = 'Please draw an algorithm: add at least one block.';
$string['pluginname'] = 'Algorithm';
$string['pluginname_help'] = 'The student draws an algorithm as a flowchart in the question and can run it. With tests, the answer is graded automatically; without tests, the teacher grades it.';
$string['pluginnameadding'] = 'Adding an Algorithm question';
$string['pluginnameediting'] = 'Editing an Algorithm question';
$string['pluginnamesummary'] = 'The student draws an algorithm as a flowchart and can run it. Graded automatically with tests computed from the teacher\'s solution, or manually.';
$string['privacy:metadata'] = 'The Algorithm question type does not store any personal data. Answers are stored by the Moodle question engine. The browser keeps a few display settings (code and variables shown or hidden) in its local storage.';
$string['responsesummary'] = 'Algorithm with {$a->blocks} block(s) in {$a->functions} function(s)';
$string['rule_aihints'] = 'You may ask the AI for a hint after an error or a failed test; it does not give the solution.';
$string['rule_ignorecase'] = 'Capital and small letters are the same.';
$string['rule_ignorespaces'] = 'Extra spaces do not count.';
$string['rule_maxblocks'] = 'At most {$a} blocks.';
$string['rule_maxgrowth'] = 'The steps must grow at most like {$a}.';
$string['rule_numbers'] = 'The tests compare only the numbers your algorithm writes, in order.';
$string['rule_numbersafter'] = 'The tests compare only the numbers your algorithm writes after the last input, in order; the text around them may be anything.';
$string['rule_stepfactor'] = 'In every test at most {$a} times the steps of the teacher\'s solution.';
$string['rule_structures'] = 'The algorithm must use: {$a}.';
$string['rule_text'] = 'The tests compare everything your algorithm writes.';
$string['rule_textafter'] = 'The tests compare what your algorithm writes after the last input.';
$string['rule_tolerance'] = 'Numbers may differ by {$a}.';
$string['showtests'] = 'Tests in the attempt';
$string['showtests_desc'] = 'Students can run the tests that are not hidden while they work';
$string['solution'] = 'Solution';
$string['solutionandtests'] = 'Solution and tests';
$string['solutionblocks'] = 'The solution has {$a} blocks, more than this limit.';
$string['solutionfails'] = 'The solution fails on test {$a->n}: {$a->error}';
$string['solutiongrowth'] = 'The steps of the solution grow like {$a}, faster than this limit.';
$string['solutionnogrowth'] = 'The growth of the solution cannot be measured: it needs a size n (an Assign such as n = 10, or the first Input) and must run for n = 10, 20 and 50.';
$string['stepfactor'] = 'Steps compared with the solution';
$string['stepfactor_help'] = 'The answer may take at most this many times the steps of the teacher\'s solution in every test (0: no limit). With 1.5 an answer may need half as many steps more than the solution. A step is one block run, as in the step counter of the editor.';
$string['stepfactorrange'] = 'Use 0 for no limit, or a number from 1.';
$string['structure_array'] = 'array';
$string['structure_dowhile'] = 'Do loop';
$string['structure_for'] = 'For loop';
$string['structure_if'] = 'If';
$string['structure_matrix'] = 'matrix';
$string['structure_record'] = 'record';
$string['structure_while'] = 'While loop';
$string['structures'] = 'Required structures';
$string['structures_help'] = 'If the answer does not use every structure ticked here, it gets no marks, even when the tests pass.';
$string['studenteditor'] = 'Student editor';
$string['template'] = 'Starting template';
$string['test'] = 'Test';
$string['testerror'] = 'Test {$a}: stopped with an error';
$string['testfailed'] = 'Test {$a}: different output';
$string['testpassed'] = 'Test {$a}: passed';
$string['tests'] = 'Tests';
$string['tests_help'] = 'Add tests and type their inputs, one value per line ("" for an empty value). A test can also call one of the functions of the algorithm: choose the function and type its arguments, for example 2, 3; the value it returns is compared. The expected outputs are computed from your solution when the question is saved. Each test has a weight (1 unless you change it): a test with weight 2 counts twice. Hidden tests are graded but students do not see their inputs and outputs.';
$string['testssummary'] = 'Tests passed: {$a->passed} of {$a->total}';
$string['tolerance'] = 'Tolerance for numbers';
$string['tolerance_help'] = 'Numbers in the output may differ from the expected ones by at most this much, for example 0.01. The rest of the line must be the same. 0 compares the numbers exactly.';
$string['tolerancenegative'] = 'The tolerance cannot be negative.';
$string['toolarge'] = 'The algorithm is too large: it may have at most {$a} blocks.';
$string['usetemplate'] = 'Students start from a separate template instead of an empty diagram';
$string['weight'] = 'Weight';
