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
 * Tests of an algorithm, the same rules as tiny_algorithm/tests: the inputs are one value per line ("" is an empty value),
 * outputs are compared without trailing spaces and empty lines; optionally only the output after the last input,
 * and only the numbers in it.
 *
 * @package    qtype_algorithm
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class tester {
    /** Step limit for one test run. */
    const MAX_STEPS = 200000;

    /** A line with only two double quotes is an empty value. */
    const EMPTY_VALUE = '""';

    /** Message when the algorithm asks for more input than the test has (when no translated one is given). */
    const NOINPUT = 'The algorithm asks for more input than the test provides.';

    /** A number in the output, as the browser finds it. */
    const NUMBER = '/-?\d+(?:\.\d+)?/';

    /** A run of spaces as JavaScript's \s+ finds it. */
    const SPACE_RUN = '/[\s\x{A0}\x{1680}\x{2000}-\x{200A}\x{2028}\x{2029}\x{202F}\x{205F}\x{3000}\x{FEFF}]+/u';

    /** White space at the end of a line, as JavaScript \s. */
    const TRAILING_SPACE = '/[\s\x{A0}\x{1680}\x{2000}-\x{200A}\x{2028}\x{2029}\x{202F}\x{205F}\x{3000}\x{FEFF}]+$/u';

    /**
     * Output for comparison: Unix line ends, no trailing spaces, no trailing empty lines.
     *
     * @param string|null $text output
     * @return string
     */
    public static function normalize(?string $text): string {
        $lines = explode("\n", preg_replace('/\r\n?/', "\n", (string) $text));
        $lines = array_map(fn($line) => preg_replace(self::TRAILING_SPACE, '', $line), $lines);
        return preg_replace('/\n+$/', '', implode("\n", $lines));
    }

    /**
     * Inputs of a test, one value per line; a line "" gives an empty value.
     *
     * @param string|null $text inputs
     * @return string[]
     */
    public static function parse_inputs(?string $text): array {
        $lines = explode("\n", preg_replace('/\r\n?/', "\n", (string) $text));
        while ($lines && end($lines) === '') {
            array_pop($lines);
        }
        return array_map(fn($line) => $line === self::EMPTY_VALUE ? '' : $line, $lines);
    }

    /**
     * Lines of the inputs of a test as written, without the empty lines at the end.
     *
     * @param string|null $text inputs
     * @return string[]
     */
    protected static function input_lines(?string $text): array {
        $lines = explode("\n", preg_replace('/\r\n?/', "\n", (string) $text));
        while ($lines && end($lines) === '') {
            array_pop($lines);
        }
        return $lines;
    }

    /**
     * The call a function test makes: Name(arguments), the arguments being the inputs of the test (one per line or
     * separated by commas).
     *
     * @param array $tc test
     * @return string|null null for a test of inputs and output
     */
    public static function call_text(array $tc): ?string {
        $call = (string) ($tc['call'] ?? '');
        if (!preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/', $call)) {
            return null;
        }
        return $call . '(' . implode(', ', self::input_lines($tc['inputs'] ?? '')) . ')';
    }

    /**
     * Run an algorithm with the inputs of a test, or call one of its functions.
     *
     * @param array $program algorithm model
     * @param string|null $inputs one value per line
     * @param string $noinput message when the algorithm asks for more input than the test has
     * @param string|null $call a call such as Sum(2, 3) instead of running the main function
     * @return array ['output' => all output, 'after' => output after the last input, 'error' => message or null,
     *     'call' => whether a function was called, 'result' => the value it returned as text]
     */
    public static function run_program(
        array $program,
        ?string $inputs,
        string $noinput = 'The algorithm asks for more input than the test provides.',
        ?string $call = null
    ): array {
        $queue = self::parse_inputs($call === null ? $inputs : '');
        $run = new interpreter($program, self::MAX_STEPS, interpreter::RANDOM_SEED);
        $error = null;
        try {
            $run->run(function () use (&$queue, $noinput) {
                if (!$queue) {
                    throw new algorithm_error($noinput);
                }
                return array_shift($queue);
            }, $call);
        } catch (algorithm_error $e) {
            $error = $e->localized();
        } catch (\Throwable $e) {
            // Anything PHP itself refuses (e.g. arithmetic on text) stops the algorithm too.
            $error = $e->getMessage();
        }
        $pieces = $run->output();
        $last = $run->inputs_read();
        $all = implode('', array_column($pieces, 0));
        $after = implode('', array_column(array_filter($pieces, fn($p) => $p[1] >= $last), 0));
        return ['output' => $all, 'after' => $after, 'error' => $error, 'call' => $call !== null, 'result' => $run->result()];
    }

    /**
     * The part of the output that is compared.
     *
     * @param array $result result of run_program
     * @param array $check ['afterinput' => only the output after the last input, 'numbers' => only the numbers]
     * @return string
     */
    public static function checked_output(array $result, array $check = []): string {
        $text = !empty($check['afterinput']) ? $result['after'] : $result['output'];
        if (!empty($result['call'])) {
            $text = (string) ($result['result'] ?? '');
        }
        if (!empty($check['numbers'])) {
            preg_match_all(self::NUMBER, $text, $m);
            return implode("\n", $m[0]);
        }
        return $text;
    }

    /**
     * Are two lines of output the same, with the comparison options of the question?
     *
     * @param string $a expected line
     * @param string $b actual line
     * @param array $check 'ignorecase', 'ignorespaces' (runs of spaces are one, the ends do not count), 'tolerance'
     * @return bool
     */
    public static function same_line(string $a, string $b, array $check = []): bool {
        $prep = function (string $line) use ($check): string {
            if (!empty($check['ignorespaces'])) {
                $line = preg_replace(self::SPACE_RUN, ' ', $line);
                $line = preg_replace('/^ | $/', '', $line);
            }
            return empty($check['ignorecase']) ? $line : mb_strtolower($line, 'UTF-8');
        };
        [$x, $y] = [$prep($a), $prep($b)];
        if ($x === $y) {
            return true;
        }
        $tolerance = (float) ($check['tolerance'] ?? 0);
        if (!($tolerance > 0) || preg_replace(self::NUMBER, '#', $x) !== preg_replace(self::NUMBER, '#', $y)) {
            return false;
        }
        preg_match_all(self::NUMBER, $x, $nx);
        preg_match_all(self::NUMBER, $y, $ny);
        foreach ($nx[0] as $i => $n) {
            if (abs((float) $n - (float) $ny[0][$i]) > $tolerance + 1e-9) {
                return false;
            }
        }
        return true;
    }

    /**
     * Index of the first line where two outputs differ, -1 when they are equal.
     *
     * @param string $expected expected output
     * @param string $actual actual output
     * @param array $check comparison options, see same_line()
     * @return int
     */
    public static function first_diff_line(string $expected, string $actual, array $check = []): int {
        $a = explode("\n", self::normalize($expected));
        $b = explode("\n", self::normalize($actual));
        for ($i = 0; $i < max(count($a), count($b)); $i++) {
            if (!isset($a[$i]) || !isset($b[$i]) || !self::same_line($a[$i], $b[$i], $check)) {
                return $i;
            }
        }
        return -1;
    }

    /**
     * Run every test against an algorithm.
     *
     * @param array $program algorithm model
     * @param array $tests [['inputs' => ..., 'expected' => ...]]
     * @param array $check what is compared, see checked_output()
     * @param string|null $noinput message for missing input
     * @return array [['pass' => bool, 'actual' => string, 'error' => string|null, 'diffline' => int]]
     */
    public static function run_tests(array $program, array $tests, array $check = [], ?string $noinput = null): array {
        $results = [];
        foreach ($tests as $tc) {
            $r = self::run_program($program, $tc['inputs'] ?? '', $noinput ?? self::NOINPUT, self::call_text($tc));
            $actual = self::checked_output($r, $check);
            $diff = self::first_diff_line((string) ($tc['expected'] ?? ''), $actual, $check);
            $results[] = ['pass' => $r['error'] === null && $diff === -1, 'actual' => $actual, 'error' => $r['error'],
                'diffline' => $diff];
        }
        return $results;
    }

    /**
     * Expected output of every test, from the solution.
     *
     * @param array $solution the teacher's algorithm
     * @param array $tests [['inputs' => ...]]
     * @param array $check what is compared, see checked_output()
     * @param string|null $noinput message for missing input
     * @return array ['tests' => tests with 'expected', 'errors' => [['index' => i, 'error' => message]]]
     */
    public static function compute_expected(array $solution, array $tests, array $check = [], ?string $noinput = null): array {
        $out = [];
        $errors = [];
        foreach (array_values($tests) as $i => $tc) {
            $r = self::run_program($solution, $tc['inputs'] ?? '', $noinput ?? self::NOINPUT, self::call_text($tc));
            if ($r['error'] !== null) {
                $errors[] = ['index' => $i, 'error' => $r['error']];
            }
            $out[] = array_merge($tc, ['inputs' => (string) ($tc['inputs'] ?? ''), 'expected' => self::checked_output($r, $check)]);
        }
        return ['tests' => $out, 'errors' => $errors];
    }

    /**
     * Control structures the algorithm uses: if, for, while, dowhile, array for a declared array and matrix for a
     * declared matrix (which is an array too).
     *
     * @param array $program algorithm model
     * @return string[]
     */
    public static function structures(array $program): array {
        $found = [];
        $walk = function ($list) use (&$walk, &$found) {
            foreach (is_array($list) ? $list : [] as $b) {
                $type = $b['type'] ?? '';
                if (in_array($type, ['if', 'for', 'while', 'dowhile'], true)) {
                    $found[$type] = true;
                }
                if ($type === 'declare' && trim((string) ($b['size'] ?? '')) !== '') {
                    $found['array'] = true;
                    if (trim((string) ($b['size2'] ?? '')) !== '') {
                        $found['matrix'] = true;
                    }
                }
                foreach (['then', 'else', 'body'] as $child) {
                    $walk($b[$child] ?? []);
                }
            }
        };
        foreach ($program['functions'] ?? [] as $f) {
            $walk($f['body'] ?? []);
            foreach ($f['params'] ?? [] as $p) {
                if (!empty($p['array'])) {
                    $found['array'] = true;
                }
            }
        }
        return array_keys($found);
    }
}
