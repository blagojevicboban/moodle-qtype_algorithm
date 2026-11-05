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
 * An array value of the algorithm. It is an object so that a function that gets an array changes the caller's
 * array, as in the browser interpreter.
 *
 * @package    qtype_algorithm
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class js_array {
    /** @var array elements */
    public array $items;

    /** @var bool written in the call of a function test ([1, 2]): its elements get the type of the parameter */
    public bool $literal = false;

    /**
     * Create an array.
     *
     * @param array $items elements
     */
    public function __construct(array $items) {
        $this->items = $items;
    }
}
