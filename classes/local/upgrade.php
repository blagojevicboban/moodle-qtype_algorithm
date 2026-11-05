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
 * Upgrade helpers.
 *
 * @package    qtype_algorithm
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class upgrade {
    /**
     * Compute the expected outputs of all tests again from the solutions (after a change of the interpreter).
     *
     * @param callable|null $log receives one line per question whose expected output changed or whose solution fails
     * @return array ['changed' => question ids, 'failing' => question ids]
     */
    public static function recompute_expected(?callable $log = null): array {
        global $DB;
        $changed = [];
        $failing = [];
        $rs = $DB->get_recordset_select('qtype_algorithm_options', "tests IS NOT NULL AND tests <> ''");
        foreach ($rs as $row) {
            $tests = json_decode((string) $row->tests, true);
            $program = self::decode((string) $row->solution);
            if (!is_array($tests) || !$tests || !$program) {
                continue;
            }
            $check = ['afterinput' => !empty($row->afterinput), 'numbers' => !empty($row->numbers)];
            $computed = tester::compute_expected($program, array_values(array_filter($tests, 'is_array')), $check);
            if ($computed['errors']) {
                $failing[] = (int) $row->questionid;
                if ($log) {
                    $log("qtype_algorithm: the solution of question {$row->questionid} fails a test: " .
                        $computed['errors'][0]['error']);
                }
            }
            $json = json_encode($computed['tests'], JSON_UNESCAPED_UNICODE);
            if ($json !== false && $json !== $row->tests) {
                $DB->set_field('qtype_algorithm_options', 'tests', $json, ['id' => $row->id]);
                $changed[] = (int) $row->questionid;
                if ($log) {
                    $log("qtype_algorithm: expected outputs of question {$row->questionid} computed again");
                }
            }
        }
        $rs->close();
        return ['changed' => $changed, 'failing' => $failing];
    }

    /**
     * The algorithm of a stored solution (base64 encoded JSON), null when there is none.
     *
     * @param string $solution stored solution
     * @return array|null
     */
    protected static function decode(string $solution): ?array {
        $json = $solution === '' ? false : base64_decode($solution, true);
        $model = $json === false ? null : json_decode($json, true, 512);
        return is_array($model) && !empty($model['functions']) && is_array($model['functions']) ? $model : null;
    }
}
