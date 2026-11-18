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

namespace qtype_algorithm\local;

use qtype_algorithm\question_test;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/question/engine/tests/helpers.php');
require_once($CFG->dirroot . '/question/type/algorithm/question.php');
require_once($CFG->dirroot . '/question/type/algorithm/tests/question_test.php');

/**
 * Unit tests of the analysis of the answers of a class: tests passed, wrong outputs, errors, grades and the blocks of
 * the solution the wrong answers miss.
 *
 * @package    qtype_algorithm
 * @category   test
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @covers     \qtype_algorithm\local\analysis
 */
final class analysis_test extends \advanced_testcase {
    /**
     * The question "write the sum" with tests (2, 3) and (-1, 1).
     *
     * @return \qtype_algorithm_question
     */
    protected function make_question(): \qtype_algorithm_question {
        $q = new \qtype_algorithm_question();
        \test_question_maker::initialise_a_question($q);
        $q->qtype = \question_bank::get_qtype('algorithm');
        $q->solution = question_test::program();
        $q->structures = ['if'];
        $tests = [['inputs' => "2\n3", 'hidden' => false], ['inputs' => "-1\n1", 'hidden' => true]];
        $q->tests = tester::compute_expected(\qtype_algorithm_question::decode_answer($q->solution), $tests)['tests'];
        return $q;
    }

    public function test_analyse(): void {
        $this->resetAfterTest();
        $q = $this->make_question();
        $answers = [
            ['answer' => question_test::program(), 'fraction' => 1.0],
            ['answer' => question_test::program('a - b'), 'fraction' => 0.0],
            ['answer' => question_test::program('a - b'), 'fraction' => 0.0],
            ['answer' => question_test::program('a / 0'), 'fraction' => null],
            ['answer' => 'not an algorithm', 'fraction' => 0.0],
        ];
        $a = analysis::analyse($q, $answers);
        $this->assertSame(4, $a['count']);
        $this->assertSame(3, $a['graded']);
        $this->assertSame(2, $a['histogram'][0]);
        $this->assertSame(1, $a['histogram'][9]);
        $this->assertSame(3, $a['failing']);
        $this->assertSame(1, $a['norun']);
        $this->assertCount(2, $a['tests']);
        $this->assertSame(['n' => 1, 'label' => '2, 3', 'hidden' => false, 'passed' => 1, 'failed' => 3, 'errors' => 1,
            'outputs' => [['output' => '-1', 'count' => 2]]], $a['tests'][0]);
        $this->assertTrue($a['tests'][1]['hidden']);
        $this->assertSame(1, $a['errors'][0]['count']);
        // No answer uses the required If.
        $this->assertSame([['name' => 'if', 'count' => 4]], $a['structures']);
        $this->assertSame(4.0, $a['medianblocks']);
        $this->assertSame(4, $a['solutionblocks']);
        // The wrong answers have the same blocks at the same places as the solution (only an expression differs).
        $this->assertSame([0.0], array_values(array_unique(array_map('floatval', array_column($a['blocks'], 'missing')))));
        $this->assertCount(4, $a['blocks']);
    }

    public function test_places_ignore_names_and_texts(): void {
        $solution = ['functions' => [['name' => 'Main', 'body' => [
            ['id' => 'a', 'type' => 'assign', 'target' => 's', 'expr' => '0'],
            ['id' => 'w', 'type' => 'while', 'cond' => 'i < 5', 'body' => [
                ['id' => 'b', 'type' => 'assign', 'target' => 's', 'expr' => 's + i'],
                ['id' => 'c', 'type' => 'assign', 'target' => 'i', 'expr' => 'i + 1'],
            ]],
            ['id' => 'o', 'type' => 'output', 'expr' => 's', 'newline' => true],
        ]]]];
        $places = ['main/assign', 'main/while', 'main/while.body/assign', 'main/while.body/assign', 'main/output'];
        $this->assertSame($places, array_column(analysis::places($solution), 'place'));
        // Other names and texts, but one assignment in the loop is missing (an endless loop).
        $endless = ['functions' => [['name' => 'Program', 'body' => [
            ['id' => 'x', 'type' => 'assign', 'target' => 'sum', 'expr' => '0'],
            ['id' => 'y', 'type' => 'while', 'cond' => 'k <= 5', 'body' => [
                ['id' => 'z', 'type' => 'assign', 'target' => 'sum', 'expr' => 'sum + k'],
            ]],
            ['id' => 'q', 'type' => 'comment', 'text' => 'done'],
            ['id' => 'v', 'type' => 'output', 'expr' => '"Sum: " & sum', 'newline' => true],
        ]]]];
        $this->assertSame([], analysis::missing_blocks($solution, []));
        // Half of the wrong answers (the endless one) miss the two assignments in the loop.
        $missing = array_map('floatval', array_column(analysis::missing_blocks($solution, [$endless, $solution]), 'missing', 'id'));
        $this->assertSame(['a' => 0.0, 'w' => 0.0, 'b' => 0.5, 'c' => 0.5, 'o' => 0.0], $missing);
    }

    public function test_median(): void {
        $this->assertSame(0.0, analysis::median([]));
        $this->assertSame(3.0, analysis::median([5, 1, 3]));
        $this->assertSame(2.5, analysis::median([4, 1, 2, 3]));
    }
}
