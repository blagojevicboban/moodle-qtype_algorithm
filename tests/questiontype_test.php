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

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->libdir . '/xmlize.php');
require_once($CFG->dirroot . '/question/format/xml/format.php');
require_once($CFG->dirroot . '/question/type/algorithm/questiontype.php');
require_once(__DIR__ . '/question_test.php');

/**
 * Unit tests for the algorithm question type: Moodle XML and the tests computed from the solution.
 *
 * @package    qtype_algorithm
 * @category   test
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @covers     \qtype_algorithm
 */
final class questiontype_test extends \advanced_testcase {
    public function test_name_and_grading(): void {
        $qtype = new \qtype_algorithm();
        $this->assertSame('algorithm', $qtype->name());
        $this->assertTrue($qtype->is_usable_by_random());
        $this->assertTrue($qtype->can_analyse_responses());
        $responses = $qtype->get_possible_responses((object) ['options' => (object) ['tests' => '[{}, {}]']]);
        $this->assertSame([0, 1], array_keys($responses));
        $this->assertArrayHasKey('error', $responses[1]);
        $this->assertNull($qtype->get_random_guess_score((object) ['options' => (object) ['tests' => '']]));
        $this->assertSame(0, $qtype->get_random_guess_score((object) ['options' => (object) ['tests' => '[{}]']]));
    }

    public function test_compute_tests(): void {
        $this->resetAfterTest();
        $tests = json_encode([
            ['inputs' => "2\n3", 'hidden' => 1, 'weight' => '2', 'x' => 'y'],
            ['inputs' => "4", 'call' => 'a b'],
        ]);
        $result = \qtype_algorithm::compute_tests(question_test::program(), $tests, []);
        $this->assertSame("5\n", $result['tests'][0]['expected']);
        $this->assertTrue($result['tests'][0]['hidden']);
        $this->assertSame(2.0, $result['tests'][0]['weight']);
        $this->assertArrayNotHasKey('x', $result['tests'][0]);
        $this->assertArrayNotHasKey('call', $result['tests'][1]);
        $this->assertSame(1, $result['errors'][0]['index']);
        $this->assertSame(get_string('noinput', 'qtype_algorithm'), $result['errors'][0]['error']);
        $none = \qtype_algorithm::compute_tests('', $tests, []);
        $this->assertSame(-1, $none['errors'][0]['index']);
    }

    public function test_xml_round_trip(): void {
        $this->resetAfterTest();
        $qtype = new \qtype_algorithm();
        $options = (object) ['solution' => question_test::program(), 'template' => '',
            'tests' => json_encode([['inputs' => "2\n3", 'hidden' => false, 'expected' => "5\n"]]),
            'afterinput' => 1, 'numbers' => 0, 'structures' => 'if,for', 'showtests' => 0, 'grademethod' => 1,
            'ignorecase' => 1, 'ignorespaces' => 0, 'tolerance' => 0.01, 'hidetools' => 1];
        $question = (object) ['options' => $options];
        $format = new \qformat_xml();
        $xml = '<question type="algorithm"><name><text>Sum</text></name>' .
            '<questiontext format="html"><text>Write the sum.</text></questiontext>' .
            $qtype->export_to_xml($question, $format) . '<hint format="html"><text>Look at the loop.</text></hint></question>';
        // Moodle 5.1 replaced xmlize() with core\xml_parser.
        $data = class_exists(\core\xml_parser::class) ? (new \core\xml_parser())->parse($xml, 0) : xmlize($xml, 0);
        $imported = $qtype->import_from_xml($data['question'], null, $format);
        $this->assertSame('algorithm', $imported->qtype);
        foreach ((array) $options as $field => $value) {
            $this->assertEquals((string) $value, (string) $imported->$field, $field);
        }
        $this->assertSame('Look at the loop.', $imported->hint[0]['text']);
        $this->assertFalse($qtype->import_from_xml(['@' => ['type' => 'shortanswer']], null, $format));
    }
}
