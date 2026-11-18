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
 * A fill-the-gaps problem: the solution with some expressions and conditions emptied. The blocks stay where they are;
 * the student only types the missing expressions. Each emptied block lists its empty fields in 'gaps'.
 *
 * @package    qtype_algorithm
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class gaps {
    /** Most gaps. */
    const MAX_GAPS = 10;

    /** Fields that can be emptied, for each kind of block. */
    const FIELDS = [
        'assign' => ['expr'], 'if' => ['cond'], 'while' => ['cond'], 'dowhile' => ['cond'], 'for' => ['start', 'end'],
        'output' => ['expr'], 'return' => ['expr'], 'call' => ['expr'], 'write' => ['expr'], 'forward' => ['distance'],
        'turn' => ['angle'],
    ];

    /** Keys of a block that hold other blocks. */
    const CHILDREN = ['then', 'else', 'body'];

    /**
     * The starting algorithm of a fill-the-gaps problem.
     *
     * @param string $solution the solution (base64 encoded JSON)
     * @param int $count number of gaps
     * @param int $seed seed of the choice (the same seed gives the same problem)
     * @return string the algorithm (base64 encoded JSON), '' when the solution cannot be read
     */
    public static function build(string $solution, int $count, int $seed): string {
        $model = \qtype_algorithm_question::decode_answer($solution);
        if ($model === null) {
            return '';
        }
        $count = max(1, min(self::MAX_GAPS, $count));
        $candidates = [];
        foreach ($model['functions'] as $k => $f) {
            self::collect($f['body'] ?? [], [$k, 'body'], $candidates);
        }
        $chosen = self::choose(count($candidates), $count, $seed);
        foreach ($chosen as $i) {
            [$path, $field] = $candidates[$i];
            $block = &self::block($model['functions'], $path);
            $block[$field] = '';
            $block['gaps'] = array_values(array_unique(array_merge($block['gaps'] ?? [], [$field])));
            unset($block);
        }
        unset($model['codeLock']);
        $json = json_encode($model, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        return $json === false ? '' : base64_encode($json);
    }

    /**
     * The fields that can be emptied, in the order of the diagram.
     *
     * @param array $list blocks
     * @param array $path keys from the functions to this list
     * @param array $out [[path of the block, field]]
     */
    protected static function collect(array $list, array $path, array &$out): void {
        foreach ($list as $i => $b) {
            if (!is_array($b)) {
                continue;
            }
            $here = array_merge($path, [$i]);
            foreach (self::FIELDS[$b['type'] ?? ''] ?? [] as $field) {
                if (trim((string) ($b[$field] ?? '')) !== '') {
                    $out[] = [$here, $field];
                }
            }
            foreach (self::CHILDREN as $key) {
                if (!empty($b[$key]) && is_array($b[$key])) {
                    self::collect($b[$key], array_merge($here, [$key]), $out);
                }
            }
        }
    }

    /**
     * A block by its path.
     *
     * @param array $root the functions
     * @param array $path keys
     * @return array reference to the block
     */
    protected static function &block(array &$root, array $path): array {
        $node = &$root;
        foreach ($path as $key) {
            $node = &$node[$key];
        }
        return $node;
    }

    /**
     * Which of $n candidates become gaps: $count different ones, chosen with a seed (Park-Miller, the same on every
     * server), in increasing order.
     *
     * @param int $n number of candidates
     * @param int $count number of gaps
     * @param int $seed seed
     * @return int[]
     */
    public static function choose(int $n, int $count, int $seed): array {
        $all = range(0, max(0, $n - 1));
        if ($n <= 0) {
            return [];
        }
        $state = abs($seed) % 2147483647 ?: 1;
        for ($i = $n - 1; $i > 0; $i--) {
            $state = ($state * 48271) % 2147483647;
            $j = $state % ($i + 1);
            [$all[$i], $all[$j]] = [$all[$j], $all[$i]];
        }
        $chosen = array_slice($all, 0, min($count, $n));
        sort($chosen);
        return $chosen;
    }
}
