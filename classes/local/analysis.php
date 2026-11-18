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
 * The analysis of the answers of a class to one algorithm question: which tests fail and with which outputs, the
 * errors, the missing structures, the grades, and which blocks of the solution the wrong answers do not have.
 *
 * @package    qtype_algorithm
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class analysis {
    /** Most wrong outputs listed for a test. */
    const TOP_OUTPUTS = 3;

    /** Most errors listed. */
    const TOP_ERRORS = 5;

    /** Longest output or error text kept (characters). */
    const MAX_TEXT = 200;

    /** Keys of a block that hold other blocks. */
    const CHILDREN = ['then', 'else', 'body'];

    /**
     * Analyse the answers.
     *
     * @param \qtype_algorithm_question $question the question (the answers of other versions are left out by the caller)
     * @param array $answers [['answer' => stored response (base64 JSON), 'fraction' => ?float]]
     * @return array see the returns of the web service qtype_algorithm_get_class_analysis
     */
    public static function analyse(\qtype_algorithm_question $question, array $answers): array {
        $tests = array_values($question->tests);
        $testrows = [];
        foreach ($tests as $i => $tc) {
            $call = tester::call_text($tc);
            $label = $call ?? str_replace("\n", ', ', trim((string) ($tc['inputs'] ?? '')));
            $testrows[$i] = ['n' => $i + 1, 'label' => self::short($label),
                'hidden' => !empty($tc['hidden']), 'passed' => 0, 'failed' => 0, 'errors' => 0, 'outputs' => []];
        }
        $histogram = array_fill(0, 10, 0);
        $errors = [];
        $structures = [];
        $blocks = [];
        $steps = [];
        $graded = 0;
        $norun = 0;
        $efficiency = 0;
        $failing = [];
        foreach ($answers as $a) {
            $response = ['answer' => (string) $a['answer']];
            $model = \qtype_algorithm_question::decode_answer($response['answer']);
            if (!$model) {
                continue;
            }
            if (isset($a['fraction']) && $a['fraction'] !== null && $a['fraction'] >= 0) {
                $graded++;
                $histogram[min(9, (int) floor($a['fraction'] * 10))]++;
            }
            $blocks[] = \qtype_algorithm_question::blocks_of($model);
            $results = $question->has_tests() && !$question->is_too_large($response) ? $question->test_results($response) : [];
            $allpass = (bool) $results;
            $allerror = (bool) $results;
            $firsterror = null;
            $total = 0;
            foreach ($results as $i => $r) {
                if (!isset($testrows[$i])) {
                    continue;
                }
                $total += (int) ($r['steps'] ?? 0);
                if (!empty($r['pass'])) {
                    $testrows[$i]['passed']++;
                    $allerror = false;
                    continue;
                }
                $allpass = false;
                $testrows[$i]['failed']++;
                if ($r['error'] !== null) {
                    $testrows[$i]['errors']++;
                    $firsterror = $firsterror ?? self::short((string) $r['error']);
                } else {
                    $allerror = false;
                    $out = self::short(trim((string) $r['actual']));
                    $testrows[$i]['outputs'][$out] = ($testrows[$i]['outputs'][$out] ?? 0) + 1;
                }
            }
            if ($results) {
                $steps[] = $total;
            }
            if ($allerror) {
                $norun++;
            }
            if ($firsterror !== null) {
                $errors[$firsterror] = ($errors[$firsterror] ?? 0) + 1;
            }
            foreach ($question->missing_structures($response) as $s) {
                $structures[$s] = ($structures[$s] ?? 0) + 1;
            }
            if ($question->efficiency_problems($response)) {
                $efficiency++;
            }
            if (!$allpass) {
                $failing[] = $model;
            }
        }

        $solution = \qtype_algorithm_question::decode_answer((string) $question->solution);
        foreach ($testrows as $i => $row) {
            arsort($row['outputs']);
            $testrows[$i]['outputs'] = self::pairs(array_slice($row['outputs'], 0, self::TOP_OUTPUTS, true), 'output');
        }
        arsort($errors);
        arsort($structures);
        return [
            'count' => count($blocks),
            'graded' => $graded,
            'histogram' => $histogram,
            'norun' => $norun,
            'efficiency' => $efficiency,
            'tests' => array_values($testrows),
            'errors' => self::pairs(array_slice($errors, 0, self::TOP_ERRORS, true), 'message'),
            'structures' => self::pairs($structures, 'name'),
            'medianblocks' => self::median($blocks),
            'solutionblocks' => $solution ? \qtype_algorithm_question::blocks_of($solution) : 0,
            'mediansteps' => self::median($steps),
            'failing' => count($failing),
            'blocks' => $solution ? self::missing_blocks($solution, $failing) : [],
        ];
    }

    /**
     * The analysis of no answers.
     *
     * @return array
     */
    public static function analyse_empty(): array {
        return ['count' => 0, 'graded' => 0, 'histogram' => array_fill(0, 10, 0), 'norun' => 0, 'efficiency' => 0,
            'tests' => [], 'errors' => [], 'structures' => [], 'medianblocks' => 0.0, 'solutionblocks' => 0,
            'mediansteps' => 0.0, 'failing' => 0, 'blocks' => [], 'otherversions' => 0, 'solution' => 'null'];
    }

    /**
     * For each block of the solution: the share of the wrong answers that have fewer blocks of its kind at its place
     * (the same function, inside the same kinds of loops and branches) than the solution. Names and texts are not
     * compared, so answers with other variable names or messages still match.
     *
     * @param array $solution the solution
     * @param array $failing the wrong answers
     * @return array [['id' => block id, 'missing' => 0..1]]
     */
    public static function missing_blocks(array $solution, array $failing): array {
        if (!$failing) {
            return [];
        }
        $blocks = self::places($solution);
        $need = array_count_values(array_column($blocks, 'place'));
        $have = [];
        foreach ($failing as $model) {
            $have[] = array_count_values(array_column(self::places($model), 'place'));
        }
        $out = [];
        foreach ($blocks as $b) {
            $missing = 0;
            foreach ($have as $counts) {
                if (($counts[$b['place']] ?? 0) < $need[$b['place']]) {
                    $missing++;
                }
            }
            $out[] = ['id' => $b['id'], 'missing' => round($missing / count($have), 3)];
        }
        return $out;
    }

    /**
     * The blocks of an algorithm with their place: the function, the kinds of the blocks around them and their own
     * kind, e.g. "main/dowhile.body/assign".
     *
     * @param array $model the algorithm
     * @return array [['id' => block id, 'place' => string]]
     */
    public static function places(array $model): array {
        $out = [];
        $walk = function (array $list, string $path) use (&$walk, &$out) {
            foreach ($list as $b) {
                if (!is_array($b) || !isset($b['type']) || $b['type'] === 'comment') {
                    continue;
                }
                $type = (string) $b['type'];
                $out[] = ['id' => (string) ($b['id'] ?? ''), 'place' => $path . '/' . $type];
                foreach (self::CHILDREN as $key) {
                    if (!empty($b[$key]) && is_array($b[$key])) {
                        $walk($b[$key], $path . '/' . $type . '.' . $key);
                    }
                }
            }
        };
        foreach (array_values($model['functions'] ?? []) as $k => $f) {
            if (is_array($f) && is_array($f['body'] ?? null)) {
                // The first function is the main one, whatever its name; the others are known by their names.
                $walk($f['body'], $k === 0 ? 'main' : \core_text::strtolower((string) ($f['name'] ?? $k)));
            }
        }
        return $out;
    }

    /**
     * The median of numbers, 0 for none.
     *
     * @param array $values numbers
     * @return float
     */
    public static function median(array $values): float {
        if (!$values) {
            return 0.0;
        }
        sort($values);
        $n = count($values);
        $mid = intdiv($n, 2);
        return $n % 2 ? (float) $values[$mid] : ($values[$mid - 1] + $values[$mid]) / 2;
    }

    /**
     * A text cut to the longest kept length.
     *
     * @param string $text
     * @return string
     */
    protected static function short(string $text): string {
        return \core_text::strlen($text) > self::MAX_TEXT ? \core_text::substr($text, 0, self::MAX_TEXT) . '…' : $text;
    }

    /**
     * Counts as a list of pairs.
     *
     * @param array $counts text => count
     * @param string $key name of the text in a pair
     * @return array [[$key => text, 'count' => n]]
     */
    protected static function pairs(array $counts, string $key): array {
        $out = [];
        foreach ($counts as $text => $count) {
            $out[] = [$key => (string) $text, 'count' => (int) $count];
        }
        return $out;
    }
}
