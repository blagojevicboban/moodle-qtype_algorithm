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

namespace qtype_algorithm;

use qtype_algorithm\local\tester;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/question/engine/tests/helpers.php');
require_once($CFG->dirroot . '/question/type/algorithm/question.php');

/**
 * Unit tests for the algorithm question: decoding, completeness, limits and automatic grading.
 *
 * @package    qtype_algorithm
 * @category   test
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @covers     \qtype_algorithm_question
 */
final class question_test extends \advanced_testcase {
    /**
     * Encode an algorithm with one function, as the editor stores it.
     *
     * @param array $body blocks of the main function
     * @return string base64 encoded JSON
     */
    public static function encode(array $body): string {
        return base64_encode(json_encode(['version' => 1, 'name' => 'Program',
            'functions' => [['name' => 'Main', 'params' => [], 'returnType' => null, 'body' => $body]]]));
    }

    /**
     * Algorithm that reads two numbers a and b and writes one expression.
     *
     * @param string $expr expression written after the inputs
     * @return string base64 encoded JSON
     */
    public static function program(string $expr = 'a + b'): string {
        return self::encode([
            ['id' => 'd', 'type' => 'declare', 'name' => 'a, b', 'varType' => 'Integer', 'size' => ''],
            ['id' => 'i1', 'type' => 'input', 'target' => 'a'],
            ['id' => 'i2', 'type' => 'input', 'target' => 'b'],
            ['id' => 'o', 'type' => 'output', 'expr' => $expr, 'newline' => true],
        ]);
    }

    /**
     * A question "write the sum" with two tests, (2, 3) and (-1, 1).
     *
     * @param int $grademethod 0: share of passed tests, 1: all tests must pass
     * @return \qtype_algorithm_question
     */
    protected function make_question(int $grademethod = 0): \qtype_algorithm_question {
        $q = new \qtype_algorithm_question();
        \test_question_maker::initialise_a_question($q);
        $q->qtype = \question_bank::get_qtype('algorithm');
        $q->name = 'Sum';
        $q->questiontext = 'Read two numbers and write their sum.';
        $q->solution = self::program();
        $tests = [['inputs' => "2\n3", 'hidden' => false], ['inputs' => "-1\n1", 'hidden' => true]];
        $q->tests = tester::compute_expected(\qtype_algorithm_question::decode_answer($q->solution), $tests)['tests'];
        $q->grademethod = $grademethod;
        return $q;
    }

    public function test_decode_answer(): void {
        $this->assertNull(\qtype_algorithm_question::decode_answer(''));
        $this->assertNull(\qtype_algorithm_question::decode_answer('not base64 !'));
        $this->assertNull(\qtype_algorithm_question::decode_answer(base64_encode('{"functions": "x"}')));
        $model = \qtype_algorithm_question::decode_answer(self::program());
        $this->assertSame('Main', $model['functions'][0]['name']);
        // Answers nested too deep or too long are not decoded.
        $deep = str_repeat('[', 100) . str_repeat(']', 100);
        $this->assertNull(\qtype_algorithm_question::decode_answer(base64_encode('{"functions": [' . $deep . ']}')));
        $long = str_repeat('A', \qtype_algorithm_question::MAX_ANSWER_LENGTH + 4);
        $this->assertNull(\qtype_algorithm_question::decode_answer($long));
    }

    public function test_complete_response(): void {
        $this->resetAfterTest();
        $q = $this->make_question();
        $this->assertFalse($q->is_complete_response([]));
        $this->assertFalse($q->is_complete_response(['answer' => self::encode([])]));
        $this->assertTrue($q->is_complete_response(['answer' => self::program()]));
        $this->assertSame('', $q->get_validation_error(['answer' => self::program()]));
        $this->assertNotSame('', $q->get_validation_error(['answer' => '']));
        $this->assertTrue($q->is_same_response(['answer' => self::program()], ['answer' => self::program()]));
        $this->assertFalse($q->is_same_response(['answer' => self::program()], ['answer' => self::program('a - b')]));
        $this->assertSame('Algorithm with 4 block(s) in 1 function(s)', $q->summarise_response(['answer' => self::program()]));
    }

    public function test_too_many_blocks(): void {
        $this->resetAfterTest();
        $q = $this->make_question();
        $blocks = array_fill(0, \qtype_algorithm_question::MAX_BLOCKS + 1, ['type' => 'comment', 'text' => '']);
        $response = ['answer' => self::encode($blocks)];
        $this->assertTrue($q->is_too_large($response));
        $this->assertFalse($q->is_complete_response($response));
        $this->assertStringContainsString((string) \qtype_algorithm_question::MAX_BLOCKS, $q->get_validation_error($response));
        $this->assertSame([], $q->test_results($response));
    }

    public function test_grade_response(): void {
        $this->resetAfterTest();
        $q = $this->make_question();
        $this->assertTrue($q->has_tests());
        $this->assertEquals([1, \question_state::$gradedright], $q->grade_response(['answer' => self::program()]));
        $this->assertEquals([1, \question_state::$gradedright], $q->grade_response(['answer' => self::program('b + a')]));
        $this->assertEquals([0, \question_state::$gradedwrong], $q->grade_response(['answer' => self::program('a * b')]));
    }

    public function test_grade_response_partial(): void {
        $this->resetAfterTest();
        // The expression a + b + a - 2 is right for (2, 3) and wrong for (-1, 1).
        $partial = ['answer' => self::program('a + b + a - 2')];
        $q = $this->make_question(0);
        [$fraction, $state] = $q->grade_response($partial);
        $this->assertEquals(0.5, $fraction);
        $this->assertEquals(\question_state::$gradedpartial, $state);
        [$fraction] = $this->make_question(1)->grade_response($partial);
        $this->assertEquals(0, $fraction);
    }

    public function test_required_structures(): void {
        $this->resetAfterTest();
        $q = $this->make_question();
        $q->structures = ['for'];
        $this->assertSame(['for'], $q->missing_structures(['answer' => self::program()]));
        $this->assertEquals(0, $q->grade_response(['answer' => self::program()])[0]);
    }

    public function test_weights(): void {
        $this->resetAfterTest();
        $q = $this->make_question();
        $q->tests[0]['weight'] = 3;
        // Right for (2, 3) only: 3 of 4.
        $this->assertEquals(0.75, $q->grade_response(['answer' => self::program('a + b + a - 2')])[0]);
        $q->tests[1]['weight'] = 0;
        $this->assertEquals(1, $q->grade_response(['answer' => self::program('a + b + a - 2')])[0]);
        $this->assertEquals(1.0, \qtype_algorithm_question::test_weight(['inputs' => '']));
    }

    public function test_function_tests_and_comparison(): void {
        $this->resetAfterTest();
        $double = fn(string $expr) => base64_encode(json_encode(['version' => 1, 'name' => 'P', 'functions' => [
            ['name' => 'Main', 'params' => [], 'returnType' => null, 'body' => []],
            ['name' => 'Double', 'params' => [['name' => 'n', 'type' => 'Integer']], 'returnType' => 'Integer',
                'body' => [['id' => 'r', 'type' => 'return', 'expr' => $expr]]],
        ]]));
        $q = $this->make_question();
        $q->solution = $double('n * 2');
        $calls = [['inputs' => '21', 'call' => 'Double'], ['inputs' => "-4\n", 'call' => 'Double']];
        $q->tests = tester::compute_expected(\qtype_algorithm_question::decode_answer($q->solution), $calls)['tests'];
        $this->assertSame(['42', '-8'], array_column($q->tests, 'expected'));
        $this->assertEquals(1, $q->grade_response(['answer' => $double('n + n')])[0]);
        $this->assertEquals(0, $q->grade_response(['answer' => $double('n * 3')])[0]);

        $this->assertTrue(tester::same_line('Sum = 5', 'SUM  =  5 ', ['ignorecase' => true, 'ignorespaces' => true]));
        $this->assertTrue(tester::same_line('Šum', 'šUM', ['ignorecase' => true]));
        $this->assertFalse(tester::same_line('Sum = 5', 'SUM = 5'));
        $this->assertTrue(tester::same_line('x = 0.333', 'x = 0.3333', ['tolerance' => 0.001]));
        $this->assertFalse(tester::same_line('x = 0.333', 'y = 0.333', ['tolerance' => 1]));
        $this->assertSame(-1, tester::first_diff_line("A\nB  C", "a\nb c", ['ignorecase' => true, 'ignorespaces' => true]));
        // The question's options reach the grading.
        $q = $this->make_question();
        $q->tests[0]['expected'] = "SUM 5\n";
        $q->tests[1]['expected'] = "SUM 0\n";
        $answer = ['answer' => self::program('"Sum " & (a + b)')];
        $this->assertEquals(0, $q->grade_response($answer)[0]);
        $q = $this->make_question();
        $q->tests[0]['expected'] = "SUM 5\n";
        $q->tests[1]['expected'] = "SUM 0\n";
        $q->ignorecase = true;
        $this->assertEquals(1, $q->grade_response($answer)[0]);
    }

    public function test_classify_response(): void {
        $this->resetAfterTest();
        $q = $this->make_question();
        $parts = $q->classify_response(['answer' => self::program('a + b + a - 2')]);
        $this->assertSame('pass', $parts[0]->responseclassid);
        $this->assertSame('fail', $parts[1]->responseclassid);
        $parts = $q->classify_response(['answer' => self::program('a / 0')]);
        $this->assertSame('error', $parts[0]->responseclassid);
        $parts = $q->classify_response(['answer' => '']);
        $this->assertNull($parts[0]->responseclassid);
    }
}
