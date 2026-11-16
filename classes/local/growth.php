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
 * How fast an algorithm grows: it runs for several sizes n, its steps are counted and the growth that fits them best is
 * named (the same measuring as tiny_algorithm/complexity, so the student sees in the editor what the grading finds).
 *
 * @package    qtype_algorithm
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class growth {
    /** Sizes measured in the grading. */
    const SIZES = [10, 20, 50, 100, 200, 500];

    /** Most steps of one run; a bigger size is not measured. */
    const MAX_RUN_STEPS = 1000000;

    /** Seed of Random and of the values entered after n (as in tiny_algorithm/complexity). */
    const SEED = 20261111;

    /** Growth rates from the slowest; a question can allow on, onlogn or on2. */
    const KEYS = ['o1', 'ologn', 'on', 'onlogn', 'on2', 'on3'];

    /** Growth rates a question can set as the most it allows. */
    const LIMITS = ['on', 'onlogn', 'on2'];

    /**
     * The value of a growth rate for n.
     *
     * @param string $key growth rate
     * @param float $n size
     * @return float
     */
    public static function value(string $key, float $n): float {
        $log = log(max($n, 2), 2);
        switch ($key) {
            case 'o1':
                return 1.0;
            case 'ologn':
                return $log;
            case 'on':
                return $n;
            case 'onlogn':
                return $n * $log;
            case 'on2':
                return $n * $n;
            default:
                return $n * $n * $n;
        }
    }

    /**
     * Where the size n can be put: an Assign of a whole number from 2 in the main function (a variable named n first),
     * or the first value the algorithm reads.
     *
     * @param array $program algorithm model
     * @return array|null ['kind' => 'var', 'id' => block id] or ['kind' => 'input'], null when there is none
     */
    public static function target(array $program): ?array {
        $found = [];
        $input = false;
        $visit = function ($list) use (&$visit, &$found, &$input) {
            foreach (is_array($list) ? $list : [] as $b) {
                if (!is_array($b)) {
                    continue;
                }
                $name = trim((string) ($b['target'] ?? ''));
                $expr = (string) ($b['expr'] ?? '');
                $number = preg_match('/^\s*\d+\s*$/', $expr) && (int) $expr >= 2;
                $isname = preg_match('/^[A-Za-z_]\w*$/', $name) && !isset($found[strtolower($name)]);
                if (($b['type'] ?? '') === 'assign' && $number && $isname) {
                    $found[strtolower($name)] = ['kind' => 'var', 'id' => (string) ($b['id'] ?? '')];
                }
                $input = $input || ($b['type'] ?? '') === 'input';
                foreach (['then', 'else', 'body'] as $k) {
                    $visit($b[$k] ?? []);
                }
            }
        };
        $functions = $program['functions'] ?? [];
        $main = null;
        foreach ($functions as $f) {
            if (strtolower((string) ($f['name'] ?? '')) === 'main') {
                $main = $f;
                break;
            }
        }
        $main = $main ?? ($functions[0] ?? null);
        if (!$main) {
            return null;
        }
        $visit($main['body'] ?? []);
        if (isset($found['n'])) {
            return $found['n'];
        }
        if ($input) {
            return ['kind' => 'input'];
        }
        return $found ? reset($found) : null;
    }

    /**
     * Count the steps of one run with size n.
     *
     * @param array $program algorithm model
     * @param array $target see target()
     * @param int $n size
     * @return int|null steps, null when the run failed (too many steps or an error)
     */
    public static function count_steps(array $program, array $target, int $n): ?int {
        if ($target['kind'] === 'var') {
            $set = function (array $list) use (&$set, $target, $n): array {
                foreach ($list as $i => $b) {
                    if (!is_array($b)) {
                        continue;
                    }
                    if (($b['id'] ?? null) === $target['id']) {
                        $list[$i]['expr'] = (string) $n;
                    }
                    foreach (['then', 'else', 'body'] as $k) {
                        if (isset($b[$k]) && is_array($b[$k])) {
                            $list[$i][$k] = $set($b[$k]);
                        }
                    }
                }
                return $list;
            };
            foreach ($program['functions'] as $j => $f) {
                $program['functions'][$j]['body'] = $set(is_array($f['body'] ?? null) ? $f['body'] : []);
            }
        }
        $seed = self::SEED;
        $first = $target['kind'] === 'input';
        $run = new interpreter($program, self::MAX_RUN_STEPS, self::SEED);
        try {
            $run->run(function ($name = '', $type = 'Integer') use (&$seed, &$first, $n) {
                if ($first) {
                    $first = false;
                    return (string) $n;
                }
                $seed = ($seed * 48271) % 2147483647;
                $v = $seed % 1000;
                switch ((string) $type) {
                    case 'Boolean':
                        return $v % 2 ? 'true' : 'false';
                    case 'String':
                        return 's' . $v;
                    default:
                        return (string) $v;
                }
            });
        } catch (\Throwable $e) {
            return null;
        }
        return $run->ticks();
    }

    /**
     * Measure the steps for every size; a size that fails ends the measuring.
     *
     * @param array $program algorithm model
     * @param int[] $sizes sizes n
     * @return array|null [['n' => n, 'steps' => steps]], null when the algorithm has no size n
     */
    public static function measure(array $program, array $sizes = self::SIZES): ?array {
        $target = self::target($program);
        if (!$target) {
            return null;
        }
        $points = [];
        foreach ($sizes as $n) {
            $steps = self::count_steps($program, $target, $n);
            if ($steps === null) {
                break;
            }
            $points[] = ['n' => $n, 'steps' => $steps];
        }
        return $points;
    }

    /**
     * The growth that fits the steps best: steps ≈ a·f(n) + b with the least squares; a faster growth wins only when
     * its error is less than half of the error of the slower one (as classify in tiny_algorithm/complexity).
     *
     * @param array $points [['n' => n, 'steps' => steps]]
     * @return string|null growth key, null with fewer than three sizes
     */
    public static function classify(array $points): ?string {
        if (count($points) < 3) {
            return null;
        }
        $count = count($points);
        $total = array_sum(array_column($points, 'steps')) / $count;
        $variance = 0.0;
        foreach ($points as $p) {
            $variance += ($p['steps'] - $total) ** 2;
        }
        $variance = $variance ?: 1.0;
        $best = null;
        foreach (self::KEYS as $key) {
            $xs = array_map(fn($p) => self::value($key, $p['n']), $points);
            $mx = array_sum($xs) / $count;
            $sxx = 0.0;
            $sxy = 0.0;
            foreach ($xs as $i => $x) {
                $sxx += ($x - $mx) ** 2;
                $sxy += ($x - $mx) * ($points[$i]['steps'] - $total);
            }
            $a = $sxx ? $sxy / $sxx : 0.0;
            if ($key !== 'o1' && $a <= 0) {
                continue;
            }
            $b = $total - $a * $mx;
            if ($key === 'o1') {
                $err = 1.0;
            } else {
                $err = 0.0;
                foreach ($xs as $i => $x) {
                    $err += ($points[$i]['steps'] - $a * $x - $b) ** 2;
                }
                $err /= $variance;
            }
            if ($best === null || $err < $best['err'] / 2) {
                $best = ['key' => $key, 'err' => $err];
            }
        }
        return $best['key'] ?? null;
    }

    /**
     * Does a growth stay within a limit?
     *
     * @param string $key measured growth
     * @param string $limit the most a question allows
     * @return bool
     */
    public static function within(string $key, string $limit): bool {
        return array_search($key, self::KEYS, true) <= array_search($limit, self::KEYS, true);
    }
}
