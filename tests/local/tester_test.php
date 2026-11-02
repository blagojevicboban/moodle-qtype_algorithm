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

/**
 * Unit tests for running algorithms on the server: tests, compared output and error messages.
 *
 * @package    qtype_algorithm
 * @category   test
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @covers     \qtype_algorithm\local\tester
 * @covers     \qtype_algorithm\local\algorithm_error
 */
final class tester_test extends \advanced_testcase {
    /**
     * An algorithm with one function.
     *
     * @param array $body blocks of the main function
     * @return array model
     */
    protected static function program(array $body): array {
        return ['version' => 1, 'name' => 'Program',
            'functions' => [['name' => 'Main', 'params' => [], 'returnType' => null, 'body' => $body]]];
    }

    public function test_run_program(): void {
        $program = self::program([
            ['type' => 'declare', 'name' => 'n', 'varType' => 'Integer', 'size' => ''],
            ['type' => 'output', 'expr' => '"Enter n"', 'newline' => true],
            ['type' => 'input', 'target' => 'n'],
            ['type' => 'output', 'expr' => '"Square: " & n * n', 'newline' => true],
        ]);
        $run = tester::run_program($program, '7');
        $this->assertNull($run['error']);
        $this->assertSame("Enter n\nSquare: 49\n", $run['output']);
        $this->assertSame("Square: 49\n", $run['after']);
        $this->assertSame("49", tester::checked_output($run, ['afterinput' => true, 'numbers' => true]));
        $this->assertSame('The algorithm asks for more input than the test provides.', tester::run_program($program, '')['error']);
    }

    public function test_error_messages_are_localized(): void {
        $this->resetAfterTest();
        $program = self::program([['type' => 'output', 'expr' => 'x + 1', 'newline' => true]]);
        $this->assertSame("Variable 'x' is not declared", tester::run_program($program, '')['error']);

        $error = new algorithm_error('notdeclared', ['name' => 'x']);
        $this->assertSame("Variable 'x' is not declared", $error->getMessage());
        $this->assertSame("Variable 'x' is not declared", $error->localized());
        // A message given as text (not a code) is kept as it is.
        $this->assertSame('Something else', (new algorithm_error('Something else'))->localized());
        // Placeholders are filled once: a value that looks like a placeholder stays as it is.
        $error = new algorithm_error('assigninteger', ['value' => '{name}', 'name' => 'n']);
        $this->assertSame("Cannot assign '{name}' to Integer n", $error->getMessage());
    }

    public function test_array_size_limit(): void {
        $program = self::program([
            ['type' => 'declare', 'name' => 'a', 'varType' => 'Integer', 'size' => '1000000'],
        ]);
        $this->assertSame('Array size 1000000 is larger than 100000', tester::run_program($program, '')['error']);
    }

    public function test_matrix(): void {
        $program = self::program([
            ['type' => 'declare', 'name' => 'm', 'varType' => 'Integer', 'size' => '2', 'size2' => '3'],
            ['type' => 'assign', 'target' => 'm[1, 2]', 'expr' => '5'],
            ['type' => 'output', 'expr' => 'm[1][2] * 2 & " " & m[0, 0]', 'newline' => true],
        ]);
        $this->assertSame("10 0\n", tester::run_program($program, '')['output']);
        $this->assertSame(['array', 'matrix'], tester::structures($program));
        $program['functions'][0]['body'][] = ['type' => 'output', 'expr' => 'm[1]', 'newline' => true];
        $this->assertSame('The number of indexes for m must be 2', tester::run_program($program, '')['error']);
        $big = self::program([['type' => 'declare', 'name' => 'b', 'varType' => 'Integer', 'size' => '1000', 'size2' => '101']]);
        $this->assertSame('Array size 1000 x 101 is larger than 100000', tester::run_program($big, '')['error']);
    }

    public function test_run_tests(): void {
        $program = self::program([
            ['type' => 'declare', 'name' => 'a, b', 'varType' => 'Integer', 'size' => ''],
            ['type' => 'input', 'target' => 'a'],
            ['type' => 'input', 'target' => 'b'],
            ['type' => 'output', 'expr' => 'a / b', 'newline' => true],
        ]);
        $tests = tester::compute_expected($program, [['inputs' => "6\n3"], ['inputs' => "1\n0"]]);
        $this->assertSame("2\n", $tests['tests'][0]['expected']);
        $this->assertSame(1, $tests['errors'][0]['index']);
        $results = tester::run_tests($program, $tests['tests']);
        $this->assertTrue($results[0]['pass']);
        $this->assertFalse($results[1]['pass']);
        $this->assertSame('Division by zero', $results[1]['error']);
    }
}
