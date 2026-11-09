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
 * An error that stops the algorithm.
 *
 * The message is English and the same as in the browser interpreter (the parity check compares them);
 * localized() gives it in the user's language from the ui_e_* strings of tiny_algorithm.
 *
 * @package    qtype_algorithm
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class algorithm_error extends \Exception {
    /** @var string[] English messages by code, as in tiny_algorithm/strings (e.* keys) */
    const MESSAGES = [
        'argcount' => "Function '{name}' expects {count} argument(s)",
        'argshape' => 'The value for {name} does not fit the parameter (a single value, an array or a matrix with rows of ' .
            'the same length)',
        'arraysize' => 'Array size {size} is larger than {max}',
        'dimensions' => 'The number of indexes for {name} must be {count}',
        'assignboolean' => "Cannot assign '{value}' to Boolean {name}",
        'assigninteger' => "Cannot assign '{value}' to Integer {name}",
        'assignreal' => "Cannot assign '{value}' to Real {name}",
        'badchar' => "Unexpected character '{c}'",
        'badexpression' => 'Bad expression',
        'badoperator' => 'Bad operator {op}',
        'badtarget' => 'Invalid assignment target',
        'calldepth' => 'Too many nested function calls (more than {max}). ' .
            'Does the recursion have a stop condition that is reached?',
        'charindex' => 'Char: index {index} is outside the string "{text}"',
        'divzero' => 'Division by zero',
        'expected' => "Expected '{op}'",
        'forstepzero' => 'For loop step cannot be 0',
        'indexrange' => "Index {index} out of range for '{name}'",
        'invalidinput' => "'{text}' is not a valid {type}",
        'memorylimit' => 'The arrays have more than {max} elements in all',
        'notarray' => "'{name}' is not an array",
        'notdeclared' => "Variable '{name}' is not declared",
        'notinloop' => '{block} can only be inside a loop',
        'outputlimit' => 'The output is longer than {max} characters',
        'steplimit' => 'Step limit exceeded (possible infinite loop)',
        'stringlimit' => 'A string is longer than {max} characters',
        'tocodeempty' => 'ToCode: empty string',
        'unexpected' => "Unexpected '{token}'",
        'unexpectedend' => 'Unexpected end of expression',
        'unknownfunction' => "Unknown function '{name}'",
        'unterminated' => 'Unterminated string',
    ];

    /** @var string|null code of the message (a key of MESSAGES), null for a message given as text */
    protected $errorcode;

    /** @var array placeholder values */
    protected $values;

    /**
     * Constructor.
     *
     * @param string $codeormessage a key of MESSAGES, or the message itself
     * @param array $values placeholder values
     */
    public function __construct(string $codeormessage, array $values = []) {
        $known = isset(self::MESSAGES[$codeormessage]);
        $this->errorcode = $known ? $codeormessage : null;
        $this->values = $values;
        parent::__construct($known ? self::fill(self::MESSAGES[$codeormessage], $values) : $codeormessage);
    }

    /**
     * Replace {name} placeholders in one pass (like fill() in tiny_algorithm/strings).
     *
     * @param string $text message with placeholders
     * @param array $values placeholder values
     * @return string
     */
    protected static function fill(string $text, array $values): string {
        return preg_replace_callback('/\{(\w+)\}/', fn($m) => array_key_exists($m[1], $values) ?
            (string)$values[$m[1]] : $m[0], $text);
    }

    /**
     * The message in the user's language (English outside Moodle).
     *
     * @return string
     */
    public function localized(): string {
        if ($this->errorcode === null || !function_exists('get_string')) {
            return $this->getMessage();
        }
        return get_string('ui_e_' . $this->errorcode, 'tiny_algorithm', (object)$this->values);
    }
}
