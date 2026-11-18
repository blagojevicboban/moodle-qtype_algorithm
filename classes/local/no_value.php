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
 * The value of a variable, element or field that has not been given one yet, with strict initialization
 * (program strictInit): reading it is an error (noinit). There is one such value; it is written as ?.
 *
 * @package    qtype_algorithm
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
final class no_value {
    /** @var no_value|null the value */
    private static ?no_value $value = null;

    /**
     * The value.
     *
     * @return no_value
     */
    public static function get(): no_value {
        return self::$value ??= new no_value();
    }

    /**
     * As text.
     *
     * @return string
     */
    public function __toString(): string {
        return '?';
    }
}
