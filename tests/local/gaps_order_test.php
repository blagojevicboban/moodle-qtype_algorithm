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
 * Unit tests of fill-the-gaps problems (the chosen fields are emptied and listed, the same seed gives the same gaps)
 * and of Check order of Parsons problems (blocks out of order, in the wrong loop, extra wrong blocks).
 *
 * @package    qtype_algorithm
 * @category   test
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @covers     \qtype_algorithm\local\gaps
 * @covers     \qtype_algorithm\local\order
 */
final class gaps_order_test extends \advanced_testcase {
    /**
     * A solution: s = 0, while i < 5 { s = s + i, i = i + 1 }, output s.
     *
     * @return array
     */
    protected static function solution(): array {
        return ['version' => 1, 'name' => 'Sum', 'functions' => [['name' => 'Main', 'params' => [], 'returnType' => null,
            'body' => [
                ['id' => 'd', 'type' => 'declare', 'name' => 's, i', 'varType' => 'Integer', 'size' => ''],
                ['id' => 'a', 'type' => 'assign', 'target' => 's', 'expr' => '0'],
                ['id' => 'w', 'type' => 'while', 'cond' => 'i < 5', 'body' => [
                    ['id' => 'b', 'type' => 'assign', 'target' => 's', 'expr' => 's + i'],
                    ['id' => 'c', 'type' => 'assign', 'target' => 'i', 'expr' => 'i + 1'],
                ]],
                ['id' => 'o', 'type' => 'output', 'expr' => 's', 'newline' => true],
            ]]]];
    }

    public function test_gaps(): void {
        $solution = base64_encode(json_encode(self::solution()));
        $model = json_decode(base64_decode(gaps::build($solution, 2, 7)), true);
        $empty = [];
        $walk = function (array $list) use (&$walk, &$empty) {
            foreach ($list as $b) {
                foreach ($b['gaps'] ?? [] as $field) {
                    $this->assertSame('', $b[$field]);
                    $empty[] = $b['id'] . '.' . $field;
                }
                $walk($b['body'] ?? []);
            }
        };
        $walk($model['functions'][0]['body']);
        $this->assertCount(2, $empty);
        // The same seed gives the same gaps; the declaration is never emptied.
        $this->assertSame(gaps::build($solution, 2, 7), gaps::build($solution, 2, 7));
        $this->assertNotContains('d.name', $empty);
        // More gaps than fields: every field is emptied (5 here: a, w, b, c, o).
        $all = json_decode(base64_decode(gaps::build($solution, 10, 3)), true);
        $this->assertSame(['expr'], $all['functions'][0]['body'][1]['gaps']);
        $this->assertSame(['cond'], $all['functions'][0]['body'][2]['gaps']);
        $this->assertSame('', gaps::build('not base64 json', 2, 1));
        $this->assertCount(3, array_unique(gaps::choose(5, 3, 1)));
        $this->assertSame([0, 1, 2, 3, 4], gaps::choose(5, 9, 1));
        $this->assertSame([], gaps::choose(0, 3, 1));
    }

    public function test_order(): void {
        $solution = self::solution();
        $this->assertSame(['wrong' => [], 'placed' => 6, 'total' => 6], order::check($solution, $solution));

        // The two assignments of the loop swapped: one of them is out of order.
        $swapped = $solution;
        $loop = &$swapped['functions'][0]['body'][2]['body'];
        $loop = [$loop[1], $loop[0]];
        unset($loop);
        $r = order::check($swapped, $solution);
        $this->assertCount(1, $r['wrong']);
        $this->assertSame(5, $r['placed']);

        // The output moved into the loop, and an extra wrong block (i - 1) left in.
        $wrong = $solution;
        $body = &$wrong['functions'][0]['body'];
        $body[2]['body'][] = $body[3];
        $body[2]['body'][] = ['id' => 'cx', 'type' => 'assign', 'target' => 'i', 'expr' => 'i - 1'];
        unset($body[3]);
        $body = array_values($body);
        unset($body);
        $r = order::check($wrong, $solution);
        sort($r['wrong']);
        $this->assertSame(['cx', 'o'], $r['wrong']);
        $this->assertSame(5, $r['placed']);
        $this->assertSame(6, $r['total']);
    }
}
