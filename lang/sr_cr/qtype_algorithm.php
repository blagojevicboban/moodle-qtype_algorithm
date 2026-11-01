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

$string['afterinput'] = 'Само испис после последњег уноса';
$string['compare'] = 'Шта се пореди';
$string['copyfromsolution'] = 'Копирај из решења';
$string['correctsolution'] = 'Решење наставника:';
$string['emptytemplate'] = 'Празан';
$string['expected'] = 'Очекивано';
$string['failed'] = 'Није прошао';
$string['got'] = 'Ваш излаз';
$string['grademethod'] = 'Оцена';
$string['grademethod_all'] = 'Пуни бодови само кад прођу сви тестови';
$string['grademethod_proportional'] = 'Удео тестова који су прошли';
$string['gradingnote'] = 'Уз тестове се одговор оцењује аутоматски: алгоритам се извршава на улазима сваког теста, а излаз се пореди са излазом вашег решења. Без тестова одговор оцењујете ручно.';
$string['hiddentest'] = 'Скривен тест';
$string['inputs'] = 'Улаз';
$string['missingstructures'] = 'Алгоритам мора да користи: {$a}. Одговор не добија бодове.';
$string['noalgorithm'] = 'Алгоритам није предат.';
$string['noinput'] = 'Алгоритам тражи више улаза него што тест садржи.';
$string['nosolution'] = 'Нацртајте решење: из њега се рачунају очекивани излази тестова.';
$string['numbers'] = 'Само бројеви (текст око њих може бити било какав)';
$string['numbers_help'] = 'Пореде се само бројеви из излаза, редом, па ученици око њих могу да напишу било какав текст. Уз „Само испис после последњег уноса“ не рачунају се ни поруке попут „Унеси број“.';
$string['passed'] = 'Прошао';
$string['pleasedrawalgorithm'] = 'Нацртајте алгоритам: додајте бар један блок.';
$string['pluginname'] = 'Алгоритам';
$string['pluginname_help'] = 'Студент у питању црта алгоритам као дијаграм тока и може га покренути. Уз тестове се одговор оцењује аутоматски, а без тестова га оцењује наставник.';
$string['pluginnameadding'] = 'Додавање питања типа Алгоритам';
$string['pluginnameediting'] = 'Измена питања типа Алгоритам';
$string['pluginnamesummary'] = 'Студент црта алгоритам као дијаграм тока и може га покренути. Оцењује се аутоматски, тестовима чији се излази рачунају из решења наставника, или ручно.';
$string['privacy:metadata'] = 'Тип питања Алгоритам не чува личне податке. Одговоре чува Moodle систем за питања. Прегледач у свом локалном складишту чува неколико подешавања приказа (да ли су код и променљиве приказани).';
$string['responsesummary'] = 'Алгоритам са {$a->blocks} блокова у {$a->functions} функција';
$string['rule_numbers'] = 'Тестови пореде само бројеве које алгоритам исписује, редом.';
$string['rule_numbersafter'] = 'Тестови пореде само бројеве које алгоритам исписује после последњег уноса, редом; текст око њих може бити било какав.';
$string['rule_structures'] = 'Алгоритам мора да користи: {$a}.';
$string['rule_text'] = 'Тестови пореде све што алгоритам исписује.';
$string['rule_textafter'] = 'Тестови пореде оно што алгоритам исписује после последњег уноса.';
$string['showtests'] = 'Тестови у покушају';
$string['showtests_desc'] = 'Ученици могу да покрећу тестове који нису скривени док раде';
$string['solution'] = 'Решење';
$string['solutionandtests'] = 'Решење и тестови';
$string['solutionfails'] = 'Решење не ради на тесту {$a->n}: {$a->error}';
$string['structure_array'] = 'низ';
$string['structure_dowhile'] = 'Do петља';
$string['structure_for'] = 'For петља';
$string['structure_if'] = 'If (гранање)';
$string['structure_while'] = 'While петља';
$string['structures'] = 'Обавезне структуре';
$string['structures_help'] = 'Ако одговор не користи сваку овде означену структуру, не добија бодове, чак и кад тестови прођу.';
$string['template'] = 'Почетни шаблон';
$string['test'] = 'Тест';
$string['tests'] = 'Тестови';
$string['tests_help'] = 'Додајте тестове и упишите улазе, једну вредност по реду ("" за празну вредност). Очекивани излази се рачунају из вашег решења кад сачувате питање. Скривени тестови се оцењују, али ученици не виде њихове улазе и излазе.';
$string['testssummary'] = 'Прошло тестова: {$a->passed} од {$a->total}';
$string['toolarge'] = 'Алгоритам је превелик: може да има највише {$a} блокова.';
$string['usetemplate'] = 'Ученици почињу од посебног шаблона уместо од празног дијаграма';
