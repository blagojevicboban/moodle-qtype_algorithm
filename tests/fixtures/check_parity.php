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
 * Development check without Moodle: php tests/fixtures/check_parity.php [fixture.json ...]
 * Runs every fixture with the PHP interpreter and reports where it differs from the browser interpreter.
 *
 * @package    qtype_algorithm
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// phpcs:disable moodle.Files.MoodleInternal.MoodleInternalGlobalState
// phpcs:disable moodle.Files.RequireLogin.Missing
spl_autoload_register(function ($class) {
    $prefix = 'qtype_algorithm\\local\\';
    if (strpos($class, $prefix) === 0) {
        require(__DIR__ . '/../../classes/local/' . substr($class, strlen($prefix)) . '.php');
    }
});

$files = array_slice($argv, 1) ?: [__DIR__ . '/parity.json'];
$bad = 0;
$total = 0;
foreach ($files as $file) {
    foreach (json_decode(file_get_contents($file), true) as $case) {
        $total++;
        $r = \qtype_algorithm\local\tester::run_program(
            $case['program'],
            $case['inputs'],
            'The algorithm asks for more input than the test provides.'
        );
        foreach (['output', 'after', 'error'] as $key) {
            if ($r[$key] !== $case[$key]) {
                $bad++;
                echo "{$case['name']} [" . str_replace("\n", ',', $case['inputs']) . "] {$key}\n  js:  " .
                    json_encode($case[$key], JSON_UNESCAPED_UNICODE) . "\n  php: " .
                    json_encode($r[$key], JSON_UNESCAPED_UNICODE) . "\n";
                break;
            }
        }
    }
}
echo "{$total} runs, {$bad} different\n";
exit($bad ? 1 : 0);
