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
 * Serbian (Latin) strings for the Algorithm question type.
 *
 * @package    qtype_algorithm
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['afterinput'] = 'Samo ispis poslije posljednjeg unosa';
$string['compare'] = 'Šta se poredi';
$string['copyfromsolution'] = 'Kopiraj iz rješenja';
$string['correctsolution'] = 'Rješenje nastavnika:';
$string['emptytemplate'] = 'Prazan';
$string['expected'] = 'Očekivano';
$string['failed'] = 'Nije prošao';
$string['got'] = 'Vaš izlaz';
$string['grademethod'] = 'Ocjena';
$string['grademethod_all'] = 'Puni bodovi samo kad prođu svi testovi';
$string['grademethod_proportional'] = 'Udio testova koji su prošli';
$string['gradingnote'] = 'Uz testove se odgovor ocjenjuje automatski: algoritam se izvršava na ulazima svakog testa, a izlaz se poredi sa izlazom vašeg rješenja. Bez testova odgovor ocjenjujete ručno.';
$string['hiddentest'] = 'Skriven test';
$string['inputs'] = 'Ulaz';
$string['missingstructures'] = 'Algoritam mora da koristi: {$a}. Odgovor ne dobija bodove.';
$string['noalgorithm'] = 'Algoritam nije predat.';
$string['noinput'] = 'Algoritam traži više ulaza nego što test sadrži.';
$string['nosolution'] = 'Nacrtajte rješenje: iz njega se računaju očekivani izlazi testova.';
$string['numbers'] = 'Samo brojevi (tekst oko njih može biti bilo kakav)';
$string['numbers_help'] = 'Porede se samo brojevi iz izlaza, redom, pa učenici oko njih mogu da napišu bilo kakav tekst. Uz „Samo ispis poslije posljednjeg unosa“ ne računaju se ni poruke poput „Unesi broj“.';
$string['passed'] = 'Prošao';
$string['pleasedrawalgorithm'] = 'Nacrtajte algoritam: dodajte bar jedan blok.';
$string['pluginname'] = 'Algoritam';
$string['pluginname_help'] = 'Student u pitanju crta algoritam kao dijagram toka i može ga pokrenuti. Uz testove se odgovor ocjenjuje automatski, a bez testova ga ocjenjuje nastavnik.';
$string['pluginnameadding'] = 'Dodavanje pitanja tipa Algoritam';
$string['pluginnameediting'] = 'Izmjena pitanja tipa Algoritam';
$string['pluginnamesummary'] = 'Student crta algoritam kao dijagram toka i može ga pokrenuti. Ocjenjuje se automatski, testovima čiji se izlazi računaju iz rješenja nastavnika, ili ručno.';
$string['privacy:metadata'] = 'Tip pitanja Algoritam ne čuva lične podatke. Odgovore čuva Moodle sistem za pitanja.';
$string['responsesummary'] = 'Algoritam sa {$a->blocks} blokova u {$a->functions} funkcija';
$string['rule_numbers'] = 'Testovi porede samo brojeve koje algoritam ispisuje, redom.';
$string['rule_numbersafter'] = 'Testovi porede samo brojeve koje algoritam ispisuje poslije posljednjeg unosa, redom; tekst oko njih može biti bilo kakav.';
$string['rule_structures'] = 'Algoritam mora da koristi: {$a}.';
$string['rule_text'] = 'Testovi porede sve što algoritam ispisuje.';
$string['rule_textafter'] = 'Testovi porede ono što algoritam ispisuje poslije posljednjeg unosa.';
$string['showtests'] = 'Testovi u pokušaju';
$string['showtests_desc'] = 'Učenici mogu da pokreću testove koji nisu skriveni dok rade';
$string['solution'] = 'Rješenje';
$string['solutionandtests'] = 'Rješenje i testovi';
$string['solutionfails'] = 'Rješenje ne radi na testu {$a->n}: {$a->error}';
$string['structure_array'] = 'niz';
$string['structure_dowhile'] = 'Do petlja';
$string['structure_for'] = 'For petlja';
$string['structure_if'] = 'If (grananje)';
$string['structure_while'] = 'While petlja';
$string['structures'] = 'Obavezne strukture';
$string['structures_help'] = 'Ako odgovor ne koristi svaku ovdje označenu strukturu, ne dobija bodove, čak i kad testovi prođu.';
$string['template'] = 'Početni šablon';
$string['test'] = 'Test';
$string['tests'] = 'Testovi';
$string['tests_help'] = 'Dodajte testove i upišite ulaze, jednu vrijednost po redu ("" za praznu vrijednost). Očekivani izlazi se računaju iz vašeg rješenja kad sačuvate pitanje. Skriveni testovi se ocjenjuju, ali učenici ne vide njihove ulaze i izlaze.';
$string['testssummary'] = 'Prošlo testova: {$a->passed} od {$a->total}';
$string['usetemplate'] = 'Učenici počinju od posebnog šablona umjesto od praznog dijagrama';
