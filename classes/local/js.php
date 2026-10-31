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
 * JavaScript value semantics for the PHP interpreter, so that it gives the same output as the browser
 * (tiny_algorithm/interpreter): every number is a float, strings convert and compare as in JavaScript.
 *
 * Values: float (number), string, bool, null (undefined) and js_array (arrays are shared, as in JavaScript).
 *
 * @package    qtype_algorithm
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class js {
    /**
     * JavaScript Number(value).
     *
     * @param mixed $value value
     * @return float
     */
    public static function to_number($value): float {
        if (is_float($value) || is_int($value)) {
            return (float) $value;
        }
        if (is_bool($value)) {
            return $value ? 1.0 : 0.0;
        }
        if (is_string($value)) {
            $text = self::trim($value);
            if ($text === '') {
                return 0.0;
            }
            if (preg_match('/^[+-]?(\d+\.?\d*|\.\d+)(e[+-]?\d+)?$/i', $text)) {
                return (float) $text;
            }
            if (preg_match('/^([+-]?)Infinity$/', $text, $m)) {
                return $m[1] === '-' ? -INF : INF;
            }
            if (preg_match('/^0x([0-9a-f]+)$/i', $text, $m)) {
                return (float) hexdec($m[1]);
            }
            if (preg_match('/^0o([0-7]+)$/i', $text, $m)) {
                return (float) octdec($m[1]);
            }
            if (preg_match('/^0b([01]+)$/i', $text, $m)) {
                return (float) bindec($m[1]);
            }
        }
        return NAN;
    }

    /**
     * JavaScript String.prototype.trim (white space and line terminators, Unicode included).
     *
     * @param string $text text
     * @return string
     */
    public static function trim(string $text): string {
        return preg_replace('/^[\s\x{FEFF}\x{A0}]+|[\s\x{FEFF}\x{A0}]+$/u', '', $text) ?? trim($text);
    }

    /**
     * JavaScript Math.trunc.
     *
     * @param float $x number
     * @return float
     */
    public static function trunc(float $x): float {
        if (is_nan($x) || is_infinite($x)) {
            return $x;
        }
        return $x < 0 ? -floor(-$x) : floor($x);
    }

    /**
     * JavaScript Math.round (halves go up).
     *
     * @param float $x number
     * @return float
     */
    public static function round(float $x): float {
        if (is_nan($x) || is_infinite($x)) {
            return $x;
        }
        $r = floor($x);
        return $x - $r >= 0.5 ? $r + 1 : $r;
    }

    /**
     * True for a finite number without a fractional part (Number.isInteger).
     *
     * @param mixed $value value
     * @return bool
     */
    public static function is_integer($value): bool {
        return is_float($value) && is_finite($value) && floor($value) === $value;
    }

    /**
     * JavaScript String(number): shortest digits that read back as the same number.
     *
     * @param float $x number
     * @return string
     */
    public static function number_to_string(float $x): string {
        if (is_nan($x)) {
            return 'NaN';
        }
        if (is_infinite($x)) {
            return $x > 0 ? 'Infinity' : '-Infinity';
        }
        if ($x == 0) {
            return '0';
        }
        $sign = $x < 0 ? '-' : '';
        $x = abs($x);
        // Shortest precision that round-trips, as digits and a decimal exponent.
        for ($p = 0; $p < 17; $p++) {
            $s = sprintf('%.' . $p . 'e', $x);
            if ((float) $s === $x) {
                break;
            }
        }
        [$mantissa, $exp] = explode('e', $s);
        $digits = str_replace('.', '', $mantissa);
        $digits = rtrim($digits, '0') ?: '0';
        $exp = (int) $exp;
        $n = strlen($digits);
        if ($exp >= 21 || $exp <= -7) {
            $rest = $n > 1 ? '.' . substr($digits, 1) : '';
            return $sign . $digits[0] . $rest . 'e' . ($exp < 0 ? '-' : '+') . abs($exp);
        }
        if ($exp < 0) {
            return $sign . '0.' . str_repeat('0', -$exp - 1) . $digits;
        }
        if ($n <= $exp + 1) {
            return $sign . $digits . str_repeat('0', $exp + 1 - $n);
        }
        return $sign . substr($digits, 0, $exp + 1) . '.' . substr($digits, $exp + 1);
    }

    /**
     * JavaScript String(value).
     *
     * @param mixed $value value
     * @return string
     */
    public static function to_string($value): string {
        if ($value === null) {
            return 'undefined';
        }
        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }
        if (is_float($value) || is_int($value)) {
            return self::number_to_string((float) $value);
        }
        if ($value instanceof js_array) {
            return implode(',', array_map(fn($v) => $v === null ? '' : self::to_string($v), $value->items));
        }
        return (string) $value;
    }

    /**
     * Text of a value in the output (interpreter fmt): fractions are rounded to 10 decimals.
     *
     * @param mixed $value value
     * @return string
     */
    public static function fmt($value): string {
        if (is_float($value) && !self::is_integer($value)) {
            return self::number_to_string(self::round($value * 1e10) / 1e10);
        }
        return self::to_string($value);
    }

    /**
     * JavaScript truthiness.
     *
     * @param mixed $value value
     * @return bool
     */
    public static function truthy($value): bool {
        if (is_bool($value)) {
            return $value;
        }
        if (is_float($value) || is_int($value)) {
            return !is_nan((float) $value) && $value != 0;
        }
        if (is_string($value)) {
            return $value !== '';
        }
        return $value !== null;
    }

    /**
     * JavaScript strict equality (===).
     *
     * @param mixed $l left
     * @param mixed $r right
     * @return bool
     */
    public static function strict_equals($l, $r): bool {
        if (is_float($l) && is_float($r)) {
            return $l == $r && !is_nan($l) && !is_nan($r);
        }
        return $l === $r;
    }

    /**
     * JavaScript relational comparison: two strings compare as text, anything else as numbers.
     *
     * @param mixed $l left
     * @param mixed $r right
     * @return int|null -1, 0 or 1, null when a number is NaN
     */
    public static function compare($l, $r): ?int {
        if (is_string($l) && is_string($r)) {
            return strcmp(self::utf16($l), self::utf16($r)) <=> 0;
        }
        $a = self::to_number($l);
        $b = self::to_number($r);
        if (is_nan($a) || is_nan($b)) {
            return null;
        }
        return $a <=> $b;
    }

    /**
     * UTF-16 (big endian) code units of a string; JavaScript strings index and compare by them.
     *
     * @param string $text UTF-8 text
     * @return string
     */
    public static function utf16(string $text): string {
        return mb_convert_encoding($text, 'UTF-16BE', 'UTF-8');
    }

    /**
     * Length of a string in UTF-16 code units (JavaScript length).
     *
     * @param string $text UTF-8 text
     * @return int
     */
    public static function length(string $text): int {
        return intdiv(strlen(self::utf16($text)), 2);
    }

    /**
     * UTF-16 code unit at an index (charCodeAt).
     *
     * @param string $text UTF-8 text
     * @param int $index index
     * @return int
     */
    public static function code_at(string $text, int $index): int {
        $units = self::utf16($text);
        return (ord($units[2 * $index]) << 8) | ord($units[2 * $index + 1]);
    }

    /**
     * String of one UTF-16 code unit (String.fromCharCode).
     *
     * @param mixed $code character code
     * @return string
     */
    public static function from_char_code($code): string {
        $n = self::to_number($code);
        $n = is_finite($n) ? (int) fmod(self::trunc($n), 65536) : 0;
        if ($n < 0) {
            $n += 65536;
        }
        return mb_convert_encoding(chr($n >> 8) . chr($n & 0xFF), 'UTF-8', 'UTF-16BE');
    }

    /**
     * Character (one UTF-16 code unit) at an index.
     *
     * @param string $text UTF-8 text
     * @param int $index index
     * @return string
     */
    public static function char_at(string $text, int $index): string {
        return self::from_char_code(self::code_at($text, $index));
    }
}
