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
 * Expression parser (Flowgorithm-like syntax), the same as tiny_algorithm/expr.
 *
 * Node kinds: num, str, bool, var, idx, call, bin, un (arrays with the key 'k').
 *
 * @package    qtype_algorithm
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class expr {
    /** Word operators. */
    const WORD_OPS = ['and' => '&&', 'or' => '||', 'not' => '!', 'mod' => '%'];

    /** Operators written in two ways. */
    const OP_ALIASES = ['=' => '==', '<>' => '!='];

    /** @var array tokens */
    protected array $toks = [];

    /** @var int position in the tokens */
    protected int $p = 0;

    /**
     * Parse an expression.
     *
     * @param string $src expression text
     * @return array AST
     * @throws algorithm_error on a syntax error
     */
    public static function parse(string $src): array {
        $parser = new self();
        $parser->toks = self::tokenize($src);
        $ast = $parser->parse_or();
        if ($parser->p < count($parser->toks)) {
            throw new algorithm_error('unexpected', ['token' => js::to_string($parser->toks[$parser->p]['v'])]);
        }
        return $ast;
    }

    /**
     * Split an expression into tokens.
     *
     * @param string $src expression text
     * @return array tokens
     * @throws algorithm_error on an unexpected character
     */
    protected static function tokenize(string $src): array {
        $chars = mb_str_split($src);
        $len = count($chars);
        $tokens = [];
        $i = 0;
        while ($i < $len) {
            $c = $chars[$i];
            $next = $chars[$i + 1] ?? '';
            if (preg_match('/^\s$/u', $c)) {
                $i++;
            } else if (preg_match('/^[0-9]$/', $c) || ($c === '.' && preg_match('/^[0-9]$/', $next))) {
                $j = $i;
                while ($j < $len && preg_match('/^[0-9.]$/', $chars[$j])) {
                    $j++;
                }
                $text = implode('', array_slice($chars, $i, $j - $i));
                // Like parseFloat, the number ends at a second decimal point.
                preg_match('/^\d*\.?\d*/', $text, $m);
                $tokens[] = ['t' => 'num', 'v' => (float) $m[0], 'int' => strpos($text, '.') === false];
                $i = $j;
            } else if ($c === '"') {
                $j = $i + 1;
                $s = '';
                while ($j < $len && $chars[$j] !== '"') {
                    if ($chars[$j] === '\\' && $j + 1 < $len) {
                        $j++;
                        $s .= ['n' => "\n", 't' => "\t"][$chars[$j]] ?? $chars[$j];
                    } else {
                        $s .= $chars[$j];
                    }
                    $j++;
                }
                if ($j >= $len) {
                    throw new algorithm_error('unterminated');
                }
                $tokens[] = ['t' => 'str', 'v' => $s];
                $i = $j + 1;
            } else if (preg_match('/^[A-Za-z_]$/', $c)) {
                $j = $i;
                while ($j < $len && preg_match('/^[A-Za-z0-9_]$/', $chars[$j])) {
                    $j++;
                }
                $w = implode('', array_slice($chars, $i, $j - $i));
                $lw = strtolower($w);
                if (isset(self::WORD_OPS[$lw])) {
                    $tokens[] = ['t' => 'op', 'v' => self::WORD_OPS[$lw]];
                } else if ($lw === 'true' || $lw === 'false') {
                    $tokens[] = ['t' => 'bool', 'v' => $lw === 'true'];
                } else {
                    $tokens[] = ['t' => 'id', 'v' => $w];
                }
                $i = $j;
            } else {
                $two = $c . $next;
                if (in_array($two, ['<=', '>=', '<>', '!=', '==', '&&', '||'], true)) {
                    $tokens[] = ['t' => 'op', 'v' => $two];
                    $i += 2;
                } else if (strpos('+-*/^%<>=&!(),[]', $c) !== false && strlen($c) === 1) {
                    $tokens[] = ['t' => 'op', 'v' => $c];
                    $i++;
                } else {
                    throw new algorithm_error('badchar', ['c' => $c]);
                }
            }
        }
        return $tokens;
    }

    /**
     * Is the next token one of the operators?
     *
     * @param string ...$ops operators
     * @return bool
     */
    protected function is_op(string ...$ops): bool {
        $t = $this->toks[$this->p] ?? null;
        return $t !== null && $t['t'] === 'op' && in_array($t['v'], $ops, true);
    }

    /**
     * Skip the expected operator.
     *
     * @param string $op operator
     * @throws algorithm_error when another token follows
     */
    protected function expect_op(string $op): void {
        if (!$this->is_op($op)) {
            throw new algorithm_error('expected', ['op' => $op]);
        }
        $this->p++;
    }

    /**
     * Left associative binary operators of one precedence level.
     *
     * @param callable $next parser of the next level
     * @param array $ops operators of this level
     * @return array AST
     */
    protected function bin_level(callable $next, array $ops): array {
        $l = $next();
        while ($this->is_op(...$ops)) {
            $op = $this->toks[$this->p++]['v'];
            $l = ['k' => 'bin', 'op' => self::OP_ALIASES[$op] ?? $op, 'l' => $l, 'r' => $next()];
        }
        return $l;
    }

    /**
     * Number, string, truth value, variable, array element, function call or parenthesised expression.
     *
     * @return array AST
     */
    protected function primary(): array {
        $t = $this->toks[$this->p++] ?? null;
        if ($t === null) {
            throw new algorithm_error('unexpectedend');
        }
        if ($t['t'] === 'num') {
            return ['k' => 'num', 'v' => $t['v'], 'int' => $t['int']];
        }
        if ($t['t'] === 'str' || $t['t'] === 'bool') {
            return ['k' => $t['t'], 'v' => $t['v']];
        }
        if ($t['t'] === 'id') {
            if ($this->is_op('(')) {
                $this->p++;
                $args = [];
                if (!$this->is_op(')')) {
                    do {
                        $args[] = $this->parse_or();
                    } while ($this->is_op(',') && ++$this->p);
                }
                $this->expect_op(')');
                return ['k' => 'call', 'name' => $t['v'], 'args' => $args];
            }
            if ($this->is_op('[')) {
                $this->p++;
                $index = $this->parse_or();
                $this->expect_op(']');
                return ['k' => 'idx', 'name' => $t['v'], 'index' => $index];
            }
            return ['k' => 'var', 'name' => $t['v']];
        }
        if ($t['t'] === 'op' && $t['v'] === '(') {
            $e = $this->parse_or();
            $this->expect_op(')');
            return $e;
        }
        throw new algorithm_error('unexpected', ['token' => js::to_string($t['v'])]);
    }

    /**
     * Power (right associative).
     *
     * @return array AST
     */
    protected function power(): array {
        $base = $this->primary();
        if ($this->is_op('^')) {
            $this->p++;
            return ['k' => 'bin', 'op' => '^', 'l' => $base, 'r' => $this->unary()];
        }
        return $base;
    }

    /**
     * Sign and negation.
     *
     * @return array AST
     */
    protected function unary(): array {
        if ($this->is_op('-', '+', '!')) {
            $op = $this->toks[$this->p++]['v'];
            return ['k' => 'un', 'op' => $op, 'e' => $this->unary()];
        }
        return $this->power();
    }

    /**
     * Multiplication, division, remainder.
     *
     * @return array AST
     */
    protected function mul(): array {
        return $this->bin_level(fn() => $this->unary(), ['*', '/', '%']);
    }

    /**
     * Addition and subtraction.
     *
     * @return array AST
     */
    protected function add(): array {
        return $this->bin_level(fn() => $this->mul(), ['+', '-']);
    }

    /**
     * String join.
     *
     * @return array AST
     */
    protected function cat(): array {
        return $this->bin_level(fn() => $this->add(), ['&']);
    }

    /**
     * Comparisons.
     *
     * @return array AST
     */
    protected function cmp(): array {
        return $this->bin_level(fn() => $this->cat(), ['==', '=', '!=', '<>', '<', '<=', '>', '>=']);
    }

    /**
     * Logical not.
     *
     * @return array AST
     */
    protected function parse_not(): array {
        if ($this->is_op('!')) {
            $this->p++;
            return ['k' => 'un', 'op' => '!', 'e' => $this->parse_not()];
        }
        return $this->cmp();
    }

    /**
     * Logical and.
     *
     * @return array AST
     */
    protected function parse_and(): array {
        return $this->bin_level(fn() => $this->parse_not(), ['&&']);
    }

    /**
     * Logical or (the whole expression).
     *
     * @return array AST
     */
    protected function parse_or(): array {
        return $this->bin_level(fn() => $this->parse_and(), ['||']);
    }
}
