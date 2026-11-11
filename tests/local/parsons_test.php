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

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/question/engine/tests/helpers.php');
require_once($CFG->dirroot . '/question/type/algorithm/question.php');

/**
 * Unit tests of Parsons problems: every block of the solution is given once, loops and branches are empty, the extra
 * wrong blocks differ from the solution, and the same seed gives the same problem.
 *
 * @package    qtype_algorithm
 * @category   test
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @covers     \qtype_algorithm\local\parsons
 */
final class parsons_test extends \advanced_testcase {
    /**
     * A solution: read n, add 1 to n in a loop, write the sum when it is bigger than 10.
     *
     * @return string base64 encoded JSON
     */
    protected static function solution(): string {
        return base64_encode(json_encode(['version' => 1, 'name' => 'Sum', 'codeLock' => true, 'functions' => [
            ['name' => 'Main', 'params' => [], 'returnType' => null, 'body' => [
                ['id' => 'd', 'type' => 'declare', 'name' => 'n, i, s', 'varType' => 'Integer', 'size' => ''],
                ['id' => 'in', 'type' => 'input', 'target' => 'n'],
                ['id' => 'f', 'type' => 'for', 'variable' => 'i', 'start' => '1', 'end' => 'n', 'step' => '1', 'body' => [
                    ['id' => 'a', 'type' => 'assign', 'target' => 's', 'expr' => 's + i'],
                ]],
                ['id' => 'c', 'type' => 'if', 'cond' => 's >= 10', 'then' => [
                    ['id' => 'o', 'type' => 'output', 'expr' => '"Sum = " & s', 'newline' => true],
                ], 'else' => []],
            ]],
        ]]));
    }

    /**
     * Blocks of the main function of a built problem.
     *
     * @param string $built base64 encoded JSON
     * @return array
     */
    protected static function blocks(string $built): array {
        $model = \qtype_algorithm_question::decode_answer($built);
        return $model['functions'][0]['body'];
    }

    public function test_every_block_once_loops_and_branches_empty(): void {
        $blocks = self::blocks(parsons::build(self::solution(), 0, 7));
        $ids = array_column($blocks, 'id');
        sort($ids);
        $this->assertSame(['a', 'c', 'd', 'f', 'in', 'o'], $ids);
        foreach ($blocks as $b) {
            foreach (['then', 'else', 'body'] as $key) {
                if (array_key_exists($key, $b)) {
                    $this->assertSame([], $b[$key]);
                }
            }
        }
        // The lock of the code language of the solution is not part of the problem.
        $this->assertArrayNotHasKey('codeLock', \qtype_algorithm_question::decode_answer(parsons::build(self::solution(), 0, 7)));
    }

    public function test_same_seed_same_problem_other_seeds_other_orders(): void {
        $this->assertSame(parsons::build(self::solution(), 2, 11), parsons::build(self::solution(), 2, 11));
        $orders = [];
        foreach (range(1, 20) as $seed) {
            $orders[implode(',', array_column(self::blocks(parsons::build(self::solution(), 0, $seed)), 'id'))] = true;
        }
        $this->assertGreaterThan(5, count($orders));
    }

    public function test_extra_wrong_blocks_have_a_small_mistake(): void {
        $blocks = self::blocks(parsons::build(self::solution(), 3, 5));
        $this->assertCount(9, $blocks);
        $byid = [];
        foreach ($blocks as $b) {
            $byid[$b['id']] = $b;
        }
        $extra = array_filter($blocks, fn($b) => preg_match('/x\d+$/', $b['id']));
        $this->assertCount(3, $extra);
        foreach ($extra as $b) {
            $original = $byid[preg_replace('/x\d+$/', '', $b['id'])];
            $this->assertSame($original['type'], $b['type']);
            $changed = array_filter(['cond', 'expr', 'start', 'end'], fn($f) => ($b[$f] ?? null) !== ($original[$f] ?? null));
            $this->assertCount(1, $changed);
        }
        // At most MAX_DISTRACTORS, and none without an expression to change.
        $this->assertLessThanOrEqual(6 + parsons::MAX_DISTRACTORS, count(self::blocks(parsons::build(self::solution(), 99, 5))));
        $this->assertSame('', parsons::build('not a solution', 2, 5));
    }

    public function test_a_question_starts_its_attempts_with_the_problem(): void {
        $this->resetAfterTest();
        $q = new \qtype_algorithm_question();
        \test_question_maker::initialise_a_question($q);
        $q->qtype = \question_bank::get_qtype('algorithm');
        $q->solution = self::solution();
        $q->parsons = true;
        $q->distractors = 1;
        $step = new \question_attempt_step();
        $q->start_attempt($step, 1);
        $start = (string) $step->get_qt_var('_parsons');
        $this->assertCount(7, self::blocks($start));
    }
}
