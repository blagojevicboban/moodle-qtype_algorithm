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
 * The value of a record (Rec in tiny_algorithm/interpreter): its type and the values of its fields by lower case name.
 * Records are values: an assignment, an argument and a parameter get a copy.
 *
 * @package    qtype_algorithm
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class record {
    /** The basic types; a field of a record has one of them. */
    const BASIC_TYPES = ['Integer', 'Real', 'String', 'Boolean'];

    /** @var array the type: ['name' => ..., 'fields' => [['name' => ..., 'type' => ...]]] */
    public $def;

    /** @var array values by lower case field name */
    public $values = [];

    /**
     * A record with the default values, or with given values.
     *
     * @param array $def the type
     * @param array|null $values values by lower case field name
     * @param bool $empty without values: the fields have no value yet (strict initialization)
     */
    public function __construct(array $def, ?array $values = null, bool $empty = false) {
        $this->def = $def;
        foreach ($def['fields'] as $f) {
            $key = strtolower($f['name']);
            if ($values !== null) {
                $this->values[$key] = $values[$key];
            } else {
                $this->values[$key] = $empty ? no_value::get() : self::default_value($f['type']);
            }
        }
    }

    /**
     * Initial value of a field (as in the interpreter: numbers are floats).
     *
     * @param string $type basic type
     * @return mixed
     */
    public static function default_value(string $type) {
        return ['Integer' => 0.0, 'Real' => 0.0, 'String' => '', 'Boolean' => false][$type];
    }

    /**
     * A copy.
     *
     * @return record
     */
    public function copy(): record {
        return new record($this->def, $this->values);
    }

    /**
     * Text of the record: Type(field = value, ...).
     *
     * @return string
     */
    public function text(): string {
        $parts = [];
        foreach ($this->def['fields'] as $f) {
            $parts[] = $f['name'] . ' = ' . js::fmt($this->values[strtolower($f['name'])]);
        }
        return $this->def['name'] . '(' . implode(', ', $parts) . ')';
    }

    /**
     * The record types of an algorithm, checked as recordTypes() in the browser.
     *
     * @param array $program algorithm model
     * @return array lower case name => type
     * @throws algorithm_error when a type is not valid
     */
    public static function types(array $program): array {
        $types = [];
        $name = '/^[A-Za-z_][A-Za-z0-9_]*$/';
        foreach (is_array($program['records'] ?? null) ? $program['records'] : [] as $def) {
            $defname = is_array($def) ? js::to_string($def['name'] ?? null) : 'undefined';
            $key = strtolower($defname);
            $fields = is_array($def) && is_array($def['fields'] ?? null) ? array_values($def['fields']) : [];
            $keys = [];
            $ok = preg_match($name, $defname) && !in_array($key, array_map('strtolower', self::BASIC_TYPES), true) &&
                !isset($types[$key]) && $fields;
            foreach ($fields as $f) {
                $fname = is_array($f) ? js::to_string($f['name'] ?? null) : '';
                $ok = $ok && preg_match($name, $fname) && in_array($f['type'] ?? null, self::BASIC_TYPES, true);
                $keys[strtolower($fname)] = true;
            }
            if (!$ok || count($keys) !== count($fields)) {
                throw new algorithm_error('badrecord', ['name' => $defname]);
            }
            $types[$key] = ['name' => $defname, 'fields' => array_map(
                fn($f) => ['name' => $f['name'], 'type' => $f['type']],
                $fields
            )];
        }
        return $types;
    }
}
