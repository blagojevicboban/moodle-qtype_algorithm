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

/**
 * Upgrade steps for the Algorithm question type.
 *
 * @package    qtype_algorithm
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Upgrade the plugin.
 *
 * @param int $oldversion version before the upgrade
 * @return bool
 */
function xmldb_qtype_algorithm_upgrade($oldversion) {
    global $DB;
    $dbman = $DB->get_manager();

    if ($oldversion < 2026102800) {
        // Options table (solution, template, tests); earlier questions get a row without tests, so they stay manually graded.
        $table = new xmldb_table('qtype_algorithm_options');
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('questionid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('solution', XMLDB_TYPE_TEXT, null, null, null, null, null);
        $table->add_field('template', XMLDB_TYPE_TEXT, null, null, null, null, null);
        $table->add_field('tests', XMLDB_TYPE_TEXT, null, null, null, null, null);
        $table->add_field('afterinput', XMLDB_TYPE_INTEGER, '2', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('numbers', XMLDB_TYPE_INTEGER, '2', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('structures', XMLDB_TYPE_CHAR, '100', null, XMLDB_NOTNULL, null, '');
        $table->add_field('showtests', XMLDB_TYPE_INTEGER, '2', null, XMLDB_NOTNULL, null, '1');
        $table->add_field('grademethod', XMLDB_TYPE_INTEGER, '2', null, XMLDB_NOTNULL, null, '0');
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $table->add_key('questionid', XMLDB_KEY_FOREIGN_UNIQUE, ['questionid'], 'question', ['id']);
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }
        $DB->execute("INSERT INTO {qtype_algorithm_options} (questionid, afterinput, numbers, structures, showtests, grademethod)
                      SELECT q.id, 0, 0, '', 1, 0
                        FROM {question} q
                       WHERE q.qtype = 'algorithm'
                         AND NOT EXISTS (SELECT 1 FROM {qtype_algorithm_options} o WHERE o.questionid = q.id)");
        upgrade_plugin_savepoint(true, 2026102800, 'qtype', 'algorithm');
    }
    return true;
}
