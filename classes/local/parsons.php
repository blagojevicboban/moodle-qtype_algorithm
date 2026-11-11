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
 * A Parsons problem: the blocks of the solution in a random order, with loops and branches empty, and extra wrong
 * blocks made from blocks of the solution with a small mistake. The student moves the blocks to their places.
 *
 * @package    qtype_algorithm
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class parsons {
    /** Most extra wrong blocks. */
    const MAX_DISTRACTORS = 5;

    /** Fields of blocks with an expression a mistake can be made in. */
    const FIELDS = ['cond', 'expr', 'end', 'start'];

    /** Small mistakes: what is found and what it becomes (both ways). */
    const MISTAKES = [['<=', '<'], ['>=', '>'], ['==', '!='], ['+ 1', '- 1'], [' and ', ' or ']];

    /** @var int state of the random numbers */
    protected $state;

    /**
     * Constructor.
     *
     * @param int $seed seed of the random order (the same seed gives the same problem)
     */
    protected function __construct(int $seed) {
        $this->state = abs($seed) % 2147483647 ?: 1;
    }

    /**
     * Random whole number from 0 to $n - 1 (Park-Miller, the same on every server).
     *
     * @param int $n
     * @return int
     */
    protected function next(int $n): int {
        $this->state = ($this->state * 48271) % 2147483647;
        return $this->state % max(1, $n);
    }

    /**
     * The starting algorithm of a Parsons problem.
     *
     * @param string $solution the solution (base64 encoded JSON)
     * @param int $distractors number of extra wrong blocks
     * @param int $seed seed of the random order
     * @return string the algorithm (base64 encoded JSON), '' when the solution cannot be read
     */
    public static function build(string $solution, int $distractors, int $seed): string {
        $model = \qtype_algorithm_question::decode_answer($solution);
        if ($model === null) {
            return '';
        }
        $p = new self($seed);
        $distractors = max(0, min(self::MAX_DISTRACTORS, $distractors));
        $lists = [];
        foreach ($model['functions'] as $k => $f) {
            $lists[$k] = [];
            $p->flatten($f['body'] ?? [], $lists[$k]);
        }
        $p->add_distractors($lists, $distractors);
        foreach ($model['functions'] as $k => $f) {
            $model['functions'][$k]['body'] = $p->shuffle($lists[$k]);
        }
        // The task is to arrange the blocks: the student sees the language of the question, not a lock of the solution.
        unset($model['codeLock']);
        $json = json_encode($model, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        return $json === false ? '' : base64_encode($json);
    }

    /**
     * All blocks of a list, nested ones too, each with its loops and branches empty.
     *
     * @param array $list blocks
     * @param array $out the flat list
     */
    protected function flatten(array $list, array &$out): void {
        foreach ($list as $b) {
            if (!is_array($b)) {
                continue;
            }
            $copy = $b;
            foreach (['then', 'else', 'body'] as $key) {
                if (array_key_exists($key, $copy)) {
                    $copy[$key] = [];
                }
            }
            $out[] = $copy;
            foreach (['then', 'else', 'body'] as $key) {
                if (!empty($b[$key]) && is_array($b[$key])) {
                    $this->flatten($b[$key], $out);
                }
            }
        }
    }

    /**
     * Add blocks with a small mistake, each in the function of the block it comes from.
     *
     * @param array $lists flat blocks of each function
     * @param int $count how many
     */
    protected function add_distractors(array &$lists, int $count): void {
        $candidates = [];
        foreach ($lists as $k => $list) {
            foreach ($list as $b) {
                foreach (self::FIELDS as $field) {
                    if (isset($b[$field]) && is_string($b[$field]) && trim($b[$field]) !== '') {
                        $candidates[] = [$k, $b, $field];
                    }
                }
            }
        }
        $made = [];
        for ($tries = 0; count($made) < $count && $candidates && $tries < 50; $tries++) {
            [$k, $b, $field] = $candidates[$this->next(count($candidates))];
            $changed = $this->mistake($b[$field]);
            $key = $b['id'] . "\n" . $field . "\n" . $changed;
            if ($changed === null || isset($made[$key])) {
                continue;
            }
            $made[$key] = true;
            $copy = $b;
            $copy[$field] = $changed;
            $copy['id'] = $b['id'] . 'x' . count($made);
            unset($copy['note']);
            $lists[$k][] = $copy;
        }
    }

    /**
     * The expression with one small mistake, or null when none fits.
     *
     * @param string $text
     * @return string|null
     */
    protected function mistake(string $text): ?string {
        $options = [];
        foreach (self::MISTAKES as [$a, $b]) {
            foreach ([[$a, $b], [$b, $a]] as [$from, $to]) {
                $at = $this->find($text, $from);
                if ($at !== null) {
                    $options[] = substr($text, 0, $at) . $to . substr($text, $at + strlen($from));
                }
            }
        }
        // A whole number one bigger.
        if (preg_match('/(?<![\w.])(\d+)(?![\w.])/', $text, $m, PREG_OFFSET_CAPTURE)) {
            $options[] = substr($text, 0, $m[1][1]) . ((int) $m[1][0] + 1) . substr($text, $m[1][1] + strlen($m[1][0]));
        }
        $options = array_values(array_unique(array_filter($options, fn($o) => $o !== $text)));
        return $options ? $options[$this->next(count($options))] : null;
    }

    /**
     * Where an operator is in an expression, outside of strings ('<' is not the start of '<=').
     *
     * @param string $text
     * @param string $op
     * @return int|null
     */
    protected function find(string $text, string $op): ?int {
        $quote = false;
        for ($i = 0; $i < strlen($text); $i++) {
            if ($text[$i] === '"') {
                $quote = !$quote;
                continue;
            }
            if ($quote || substr($text, $i, strlen($op)) !== $op) {
                continue;
            }
            $next = $text[$i + strlen($op)] ?? '';
            $prev = $i > 0 ? $text[$i - 1] : '';
            // A one-character comparison must not be part of <=, >=, == or !=.
            if (strlen($op) === 1 && ($next === '=' || $prev === '<' || $prev === '>' || $prev === '!' || $prev === '=')) {
                continue;
            }
            return $i;
        }
        return null;
    }

    /**
     * The blocks in a random order (Fisher-Yates).
     *
     * @param array $list
     * @return array
     */
    protected function shuffle(array $list): array {
        for ($i = count($list) - 1; $i > 0; $i--) {
            $j = $this->next($i + 1);
            [$list[$i], $list[$j]] = [$list[$j], $list[$i]];
        }
        return $list;
    }
}
