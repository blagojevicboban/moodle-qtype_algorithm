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
 * Serbian (Cyrillic) strings for the Algorithm question type.
 *
 * @package    qtype_algorithm
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['afterinput'] = 'Само испис послије посљедњег уноса';
$string['compare'] = 'Шта се пореди';
$string['copyfromsolution'] = 'Копирај из рјешења';
$string['correctsolution'] = 'Рјешење наставника:';
$string['emptytemplate'] = 'Празан';
$string['expected'] = 'Очекивано';
$string['failed'] = 'Није прошао';
$string['got'] = 'Ваш излаз';
$string['grademethod'] = 'Оцјена';
$string['grademethod_all'] = 'Пуни бодови само кад прођу сви тестови';
$string['grademethod_proportional'] = 'Удио тестова који су прошли';
$string['gradingnote'] = 'Уз тестове се одговор оцјењује аутоматски: алгоритам се извршава на улазима сваког теста, а излаз се пореди са излазом вашег рјешења. Без тестова одговор оцјењујете ручно.';
$string['hiddentest'] = 'Скривен тест';
$string['inputs'] = 'Улаз';
$string['missingstructures'] = 'Алгоритам мора да користи: {$a}. Одговор не добија бодове.';
$string['noalgorithm'] = 'Алгоритам није предат.';
$string['noinput'] = 'Алгоритам тражи више улаза него што тест садржи.';
$string['nosolution'] = 'Нацртајте рјешење: из њега се рачунају очекивани излази тестова.';
$string['numbers'] = 'Само бројеви (текст око њих може бити било какав)';
$string['numbers_help'] = 'Пореде се само бројеви из излаза, редом, па ученици око њих могу да напишу било какав текст. Уз „Само испис послије посљедњег уноса“ не рачунају се ни поруке попут „Унеси број“.';
$string['passed'] = 'Прошао';
$string['pleasedrawalgorithm'] = 'Нацртајте алгоритам: додајте бар један блок.';
$string['pluginname'] = 'Алгоритам';
$string['pluginname_help'] = 'Студент у питању црта алгоритам као дијаграм тока и може га покренути. Уз тестове се одговор оцјењује аутоматски, а без тестова га оцјењује наставник.';
$string['pluginnameadding'] = 'Додавање питања типа Алгоритам';
$string['pluginnameediting'] = 'Измјена питања типа Алгоритам';
$string['pluginnamesummary'] = 'Студент црта алгоритам као дијаграм тока и може га покренути. Оцјењује се аутоматски, тестовима чији се излази рачунају из рјешења наставника, или ручно.';
$string['privacy:metadata'] = 'Тип питања Алгоритам не чува личне податке. Одговоре чува Moodle систем за питања.';
$string['responsesummary'] = 'Алгоритам са {$a->blocks} блокова у {$a->functions} функција';
$string['rule_numbers'] = 'Тестови пореде само бројеве које алгоритам исписује, редом.';
$string['rule_numbersafter'] = 'Тестови пореде само бројеве које алгоритам исписује послије посљедњег уноса, редом; текст око њих може бити било какав.';
$string['rule_structures'] = 'Алгоритам мора да користи: {$a}.';
$string['rule_text'] = 'Тестови пореде све што алгоритам исписује.';
$string['rule_textafter'] = 'Тестови пореде оно што алгоритам исписује послије посљедњег уноса.';
$string['showtests'] = 'Тестови у покушају';
$string['showtests_desc'] = 'Ученици могу да покрећу тестове који нису скривени док раде';
$string['solution'] = 'Рјешење';
$string['solutionandtests'] = 'Рјешење и тестови';
$string['solutionfails'] = 'Рјешење не ради на тесту {$a->n}: {$a->error}';
$string['structure_array'] = 'низ';
$string['structure_dowhile'] = 'Do петља';
$string['structure_for'] = 'For петља';
$string['structure_if'] = 'If (гранање)';
$string['structure_while'] = 'While петља';
$string['structures'] = 'Обавезне структуре';
$string['structures_help'] = 'Ако одговор не користи сваку овдје означену структуру, не добија бодове, чак и кад тестови прођу.';
$string['template'] = 'Почетни шаблон';
$string['test'] = 'Тест';
$string['tests'] = 'Тестови';
$string['tests_help'] = 'Додајте тестове и упишите улазе, једну вриједност по реду ("" за празну вриједност). Очекивани излази се рачунају из вашег рјешења кад сачувате питање. Скривени тестови се оцјењују, али ученици не виде њихове улазе и излазе.';
$string['testssummary'] = 'Прошло тестова: {$a->passed} од {$a->total}';
$string['usetemplate'] = 'Ученици почињу од посебног шаблона умјесто од празног дијаграма';
