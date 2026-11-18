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
 * Check order of a Parsons problem: which blocks of the student's arrangement are not where the solution has them.
 * A block is in place when it is in the same list as in the solution (the same function, inside the same loop or
 * branch) and in the longest run of blocks that keep the order of the solution there. Blocks are compared by what they
 * do (kind and text), so two equal blocks can change places. Extra wrong blocks are never in place.
 *
 * @package    qtype_algorithm
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class order {
    /** Keys of a block that hold other blocks. */
    const CHILDREN = ['then', 'else', 'body'];

    /** Keys of a block that do not change what it does. */
    const IGNORED = ['id', 'note', 'collapsed', 'gaps', 'then', 'else', 'body'];

    /**
     * Compare an arrangement with the solution.
     *
     * @param array $answer the student's algorithm
     * @param array $solution the solution
     * @return array ['wrong' => ids of the blocks not in place, 'placed' => blocks in place, 'total' => blocks of the solution]
     */
    public static function check(array $answer, array $solution): array {
        $want = self::lists($solution);
        $wrong = [];
        $placed = 0;
        foreach (self::lists($answer) as $key => $blocks) {
            $keep = self::lcs(array_column($blocks, 'sig'), array_column($want[$key] ?? [], 'sig'));
            foreach ($blocks as $i => $b) {
                if (isset($keep[$i])) {
                    $placed++;
                } else {
                    $wrong[] = $b['id'];
                }
            }
        }
        $total = 0;
        foreach ($want as $blocks) {
            $total += count($blocks);
        }
        return ['wrong' => $wrong, 'placed' => $placed, 'total' => $total];
    }

    /**
     * The lists of blocks of an algorithm, each known by its place: the function and the blocks around it.
     *
     * @param array $model the algorithm
     * @return array place => [['id' => block id, 'sig' => what the block does]]
     */
    public static function lists(array $model): array {
        $out = [];
        $walk = function (array $list, string $key) use (&$walk, &$out) {
            $out[$key] = $out[$key] ?? [];
            foreach ($list as $b) {
                if (!is_array($b)) {
                    continue;
                }
                $sig = self::signature($b);
                $out[$key][] = ['id' => (string) ($b['id'] ?? ''), 'sig' => $sig];
                foreach (self::CHILDREN as $child) {
                    if (array_key_exists($child, $b) && is_array($b[$child])) {
                        $walk($b[$child], $key . '/' . $sig . '.' . $child);
                    }
                }
            }
        };
        foreach (array_values($model['functions'] ?? []) as $k => $f) {
            if (is_array($f) && is_array($f['body'] ?? null)) {
                $walk($f['body'], $k === 0 ? 'main' : \core_text::strtolower((string) ($f['name'] ?? $k)));
            }
        }
        return $out;
    }

    /**
     * What a block does: its kind and fields, without spaces and case.
     *
     * @param array $b block
     * @return string
     */
    public static function signature(array $b): string {
        $fields = array_diff_key($b, array_flip(self::IGNORED));
        ksort($fields);
        return preg_replace('/\s+/u', '', \core_text::strtolower(json_encode($fields, JSON_UNESCAPED_UNICODE)));
    }

    /**
     * The positions in $a of a longest common subsequence of $a and $b.
     *
     * @param string[] $a
     * @param string[] $b
     * @return array position in $a => true
     */
    protected static function lcs(array $a, array $b): array {
        $n = count($a);
        $m = count($b);
        $len = array_fill(0, $n + 1, array_fill(0, $m + 1, 0));
        for ($i = $n - 1; $i >= 0; $i--) {
            for ($j = $m - 1; $j >= 0; $j--) {
                $len[$i][$j] = $a[$i] === $b[$j] ? $len[$i + 1][$j + 1] + 1 : max($len[$i + 1][$j], $len[$i][$j + 1]);
            }
        }
        $keep = [];
        for ($i = 0, $j = 0; $i < $n && $j < $m;) {
            if ($a[$i] === $b[$j]) {
                $keep[$i] = true;
                $i++;
                $j++;
            } else if ($len[$i + 1][$j] >= $len[$i][$j + 1]) {
                $i++;
            } else {
                $j++;
            }
        }
        return $keep;
    }
}
