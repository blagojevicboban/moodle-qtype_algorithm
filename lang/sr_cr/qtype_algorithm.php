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
$string['answerlegend'] = 'Ваш алгоритам';
$string['cachedef_results'] = 'Резултати тестова одговора са алгоритмом';
$string['compare'] = 'Шта се пореди';
$string['copyfromsolution'] = 'Копирај из решења';
$string['correctsolution'] = 'Решење наставника:';
$string['emptytemplate'] = 'Празан';
$string['expected'] = 'Очекивано';
$string['failed'] = 'Није прошао';
$string['got'] = 'Ваш излаз';
$string['grademethod'] = 'Оцена';
$string['grademethod_all'] = 'Пуни бодови само кад прођу сви тестови';
$string['grademethod_proportional'] = 'Удео тестова који су прошли, по њиховој тежини';
$string['gradingnote'] = 'Уз тестове се одговор оцењује аутоматски: алгоритам се извршава на улазима сваког теста, а излаз се пореди са излазом вашег решења. Без тестова одговор оцењујете ручно.';
$string['hiddentest'] = 'Скривен тест';
$string['hidetools'] = 'Сакриј генерисани кôд и увоз и извоз датотека';
$string['hidetools_help'] = 'Ученици у едитору током покушаја не виде панел кода, увоз и извоз .fprg датотека ни дугмад за слике. Ово одвраћа од преписивања кода из дијаграма (или дијаграма из датотеке), али ништа не закључава. Преглед после покушаја приказује кôд као и обично.';
$string['ignorecase'] = 'Велика и мала слова се не разликују';
$string['ignorespaces'] = 'Вишак размака се не рачуна';
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
$string['rule_ignorecase'] = 'Велика и мала слова се не разликују.';
$string['rule_ignorespaces'] = 'Вишак размака се не рачуна.';
$string['rule_numbers'] = 'Тестови пореде само бројеве које алгоритам исписује, редом.';
$string['rule_numbersafter'] = 'Тестови пореде само бројеве које алгоритам исписује после последњег уноса, редом; текст око њих може бити било какав.';
$string['rule_structures'] = 'Алгоритам мора да користи: {$a}.';
$string['rule_text'] = 'Тестови пореде све што алгоритам исписује.';
$string['rule_textafter'] = 'Тестови пореде оно што алгоритам исписује после последњег уноса.';
$string['rule_tolerance'] = 'Бројеви смеју да се разликују за {$a}.';
$string['showtests'] = 'Тестови у покушају';
$string['showtests_desc'] = 'Ученици могу да покрећу тестове који нису скривени док раде';
$string['solution'] = 'Решење';
$string['solutionandtests'] = 'Решење и тестови';
$string['solutionfails'] = 'Решење не ради на тесту {$a->n}: {$a->error}';
$string['structure_array'] = 'низ';
$string['structure_dowhile'] = 'Do петља';
$string['structure_for'] = 'For петља';
$string['structure_if'] = 'If (гранање)';
$string['structure_matrix'] = 'матрица';
$string['structure_while'] = 'While петља';
$string['structures'] = 'Обавезне структуре';
$string['structures_help'] = 'Ако одговор не користи сваку овде означену структуру, не добија бодове, чак и кад тестови прођу.';
$string['studenteditor'] = 'Едитор за ученике';
$string['template'] = 'Почетни шаблон';
$string['test'] = 'Тест';
$string['testerror'] = 'Тест {$a}: прекинут грешком';
$string['testfailed'] = 'Тест {$a}: другачији испис';
$string['testpassed'] = 'Тест {$a}: прошао';
$string['tests'] = 'Тестови';
$string['tests_help'] = 'Додајте тестове и упишите улазе, једну вредност по реду ("" за празну вредност). Тест може и да позове једну од функција алгоритма: изаберите функцију и упишите аргументе, на пример 2, 3; пореди се вредност коју врати. Очекивани излази се рачунају из вашег решења кад сачувате питање. Сваки тест има тежину (1 ако је не промените): тест са тежином 2 вреди двоструко. Скривени тестови се оцењују, али ученици не виде њихове улазе и излазе.';
$string['testssummary'] = 'Прошло тестова: {$a->passed} од {$a->total}';
$string['tolerance'] = 'Толеранција за бројеве';
$string['tolerance_help'] = 'Бројеви у испису смеју да се разликују од очекиваних највише за оволико, на пример 0.01. Остатак реда мора бити исти. 0 пореди бројеве тачно.';
$string['tolerancenegative'] = 'Толеранција не може бити негативна.';
$string['toolarge'] = 'Алгоритам је превелик: може да има највише {$a} блокова.';
$string['usetemplate'] = 'Ученици почињу од посебног шаблона уместо од празног дијаграма';
$string['weight'] = 'Тежина';
