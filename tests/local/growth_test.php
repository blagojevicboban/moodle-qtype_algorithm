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
 * Tests of the efficiency of answers: the growth measured for several sizes n, the steps of every test compared with
 * the solution, the number of blocks and the penalty in the grade.
 *
 * @package    qtype_algorithm
 * @category   test
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @covers     \qtype_algorithm\local\growth
 * @covers     \qtype_algorithm_question
 */
final class growth_test extends \advanced_testcase {
    /**
     * The sum 1 + 2 + … + n for an n that is read, in three ways.
     *
     * @param string $kind constant (a formula), linear (one loop) or quadratic (adds 1 n·n times)
     * @return array blocks of the main function
     */
    public static function sum_blocks(string $kind): array {
        $blocks = [
            ['id' => 'd', 'type' => 'declare', 'name' => 'n, s, i, j', 'varType' => 'Integer', 'size' => ''],
            ['id' => 'in', 'type' => 'input', 'target' => 'n'],
        ];
        if ($kind === 'constant') {
            $blocks[] = ['id' => 'f', 'type' => 'assign', 'target' => 's', 'expr' => 'n * (n + 1) / 2'];
        } else if ($kind === 'linear') {
            $blocks[] = ['id' => 'l', 'type' => 'for', 'variable' => 'i', 'start' => '1', 'end' => 'n', 'step' => '1', 'body' => [
                ['id' => 'a', 'type' => 'assign', 'target' => 's', 'expr' => 's + i'],
            ]];
        } else {
            $blocks[] = ['id' => 'l', 'type' => 'for', 'variable' => 'i', 'start' => '1', 'end' => 'n', 'step' => '1', 'body' => [
                ['id' => 'l2', 'type' => 'for', 'variable' => 'j', 'start' => '1', 'end' => 'i', 'step' => '1', 'body' => [
                    ['id' => 'a', 'type' => 'assign', 'target' => 's', 'expr' => 's + 1'],
                ]],
            ]];
        }
        $blocks[] = ['id' => 'o', 'type' => 'output', 'expr' => 's', 'newline' => true];
        return $blocks;
    }

    /**
     * The model of an algorithm with only a main function.
     *
     * @param array $body blocks
     * @return array
     */
    protected static function model(array $body): array {
        return json_decode(base64_decode(question_test::encode($body)), true);
    }

    /**
     * A question "write the sum 1 + … + n" with the linear solution and two tests.
     *
     * @return \qtype_algorithm_question
     */
    protected function make_question(): \qtype_algorithm_question {
        $q = new \qtype_algorithm_question();
        \test_question_maker::initialise_a_question($q);
        $q->qtype = \question_bank::get_qtype('algorithm');
        $q->name = 'Sum to n';
        $q->questiontext = 'Read n and write 1 + 2 + … + n.';
        $q->solution = question_test::encode(self::sum_blocks('linear'));
        $tests = [['inputs' => '10', 'hidden' => false], ['inputs' => '40', 'hidden' => false]];
        $q->tests = tester::compute_expected(\qtype_algorithm_question::decode_answer($q->solution), $tests)['tests'];
        return $q;
    }

    public function test_growth_of_three_sums(): void {
        $this->assertSame('o1', growth::classify(growth::measure(self::model(self::sum_blocks('constant')))));
        $this->assertSame('on', growth::classify(growth::measure(self::model(self::sum_blocks('linear')))));
        $this->assertSame('on2', growth::classify(growth::measure(self::model(self::sum_blocks('quadratic')))));
    }

    public function test_the_size_is_an_assign_of_n_or_the_first_input(): void {
        $body = self::sum_blocks('linear');
        $this->assertSame(['kind' => 'input'], growth::target(self::model($body)));
        $body[1] = ['id' => 'n10', 'type' => 'assign', 'target' => 'n', 'expr' => '10'];
        $this->assertSame(['kind' => 'var', 'id' => 'n10'], growth::target(self::model($body)));
        $points = growth::measure(self::model($body), [10, 20]);
        $this->assertSame([10, 20], array_column($points, 'n'));
        $this->assertLessThan($points[1]['steps'], $points[0]['steps']);
        $this->assertNull(growth::target(self::model([['id' => 'o', 'type' => 'output', 'expr' => '1', 'newline' => true]])));
    }

    public function test_the_steps_are_those_of_the_editor(): void {
        // Declare, Input, the For block (one step before it starts, one for each round), 10 Assigns and Output; the
        // parity fixture checks that the editor counts the same.
        $r = tester::run_program(self::model(self::sum_blocks('linear')), '10');
        $this->assertSame("55\n", $r['output']);
        $this->assertSame(4 + 2 * 10, $r['steps']);
    }

    public function test_within(): void {
        $this->assertTrue(growth::within('on', 'onlogn'));
        $this->assertTrue(growth::within('onlogn', 'onlogn'));
        $this->assertFalse(growth::within('on2', 'onlogn'));
        $this->assertTrue(growth::within('o1', 'on'));
    }

    public function test_steps_compared_with_the_solution(): void {
        $this->resetAfterTest();
        $q = $this->make_question();
        $this->assertArrayHasKey('steps', $q->tests[0]);
        $q->stepfactor = 1.5;
        $fast = ['answer' => question_test::encode(self::sum_blocks('constant'))];
        $slow = ['answer' => question_test::encode(self::sum_blocks('quadratic'))];
        $this->assertSame([], $q->efficiency_problems($fast));
        $problems = $q->efficiency_problems($slow);
        $this->assertSame(['steps', 'steps'], array_column($problems, 'problem'));
        $this->assertSame(2, $problems[1]['a']['n']);
        $this->assertEqualsWithDelta(1.0, $q->grade_response($fast)[0], 1e-9);
        $this->assertEqualsWithDelta(0.5, $q->grade_response($slow)[0], 1e-9);
        $q->efficiencypenalty = 100;
        $q2 = clone $q;
        $this->assertEqualsWithDelta(0.0, $q2->grade_response($slow)[0], 1e-9);
    }

    public function test_growth_and_blocks_in_the_grade(): void {
        $this->resetAfterTest();
        $q = $this->make_question();
        $q->maxgrowth = 'on';
        $q->efficiencypenalty = 30;
        $slow = ['answer' => question_test::encode(self::sum_blocks('quadratic'))];
        $problems = $q->efficiency_problems($slow);
        $this->assertSame('growth', $problems[0]['problem']);
        $this->assertSame(['growth' => 'on2', 'max' => 'on'], $problems[0]['a']);
        $this->assertEqualsWithDelta(0.7, $q->grade_response($slow)[0], 1e-9);
        $linear = ['answer' => question_test::encode(self::sum_blocks('linear'))];
        $this->assertSame([], $q->efficiency_problems($linear));
        $q3 = $this->make_question();
        $q3->maxblocks = 4;
        $this->assertSame([['problem' => 'blocks', 'a' => ['blocks' => 5, 'max' => 4]]], $q3->efficiency_problems($linear));
        // A wrong answer gets nothing anyway; the penalty does not make it negative.
        $wrong = ['answer' => question_test::encode([['id' => 'o', 'type' => 'output', 'expr' => '0', 'newline' => true]])];
        $this->assertEqualsWithDelta(0.0, $q3->grade_response($wrong)[0], 1e-9);
    }
}
