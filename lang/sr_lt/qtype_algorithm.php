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

$string['afterinput'] = 'Samo ispis posle poslednjeg unosa';
$string['aihints'] = 'AI pomoć';
$string['aihints_desc'] = 'Učenici mogu da zatraže pomoć od veštačke inteligencije sajta za greške i neuspele testove';
$string['aihints_help'] = 'Kada je AI pomoć uključena u podešavanjima dodatka Algoritam (dijagram toka) i sajt ima AI provajdera, učenici u pokušaju dobijaju dugmad Objasni uz AI (posle greške) i AI pomoć (pored neuspelog testa). Veštačka inteligencija dobija učenički algoritam kao pseudo-kod, grešku ili vidljivi test i tekst pitanja, uz uputstvo da nikada ne da rešenje. Na ispitima je ostavite isključenu.';
$string['answerlegend'] = 'Vaš algoritam';
$string['cachedef_results'] = 'Rezultati testova odgovora sa algoritmom';
$string['compare'] = 'Šta se poredi';
$string['copyfromsolution'] = 'Kopiraj iz rešenja';
$string['correctsolution'] = 'Rešenje nastavnika:';
$string['distractors'] = 'Dodatni pogrešni blokovi';
$string['distractors_help'] = 'Blokovi napravljeni od blokova rešenja sa malom greškom (< umesto <=, - 1 umesto + 1, or umesto and, broj veći za jedan). Učenici treba da ih izostave.';
$string['efficiency'] = 'Efikasnost';
$string['efficiency_blocks'] = 'Algoritam ima {$a->blocks} blokova; dozvoljeno je najviše {$a->max}.';
$string['efficiency_growth'] = 'Broj koraka algoritma raste kao {$a->growth}; dozvoljeno je najviše {$a->max}.';
$string['efficiency_growthunknown'] = 'Rast algoritma nije mogao da se izmeri: potrebna je veličina n (dodela kao n = 10, ili prvi unos) i algoritam mora da radi za n = 10, 20 i 50.';
$string['efficiency_steps'] = 'Test {$a->n}: algoritam je napravio {$a->steps} koraka; dozvoljeno je najviše {$a->max}.';
$string['efficiencypenalty'] = 'Umanjenje za odgovor koji nije dovoljno efikasan (%)';
$string['efficiencypenalty_help'] = 'Kada odgovor prolazi testove, ali ne ispunjava uslov efikasnosti (koraci, rast ili blokovi), ovoliko procenata se oduzima od ocene. 100 ne daje poene takvom odgovoru, 0 samo prikazuje poruku.';
$string['efficiencypenaltyapplied'] = 'Zbog toga se od ocene oduzima {$a} %.';
$string['efficiencypenaltyrange'] = 'Umanjenje je procenat od 0 do 100.';
$string['emptytemplate'] = 'Prazan';
$string['expected'] = 'Očekivano';
$string['failed'] = 'Nije prošao';
$string['got'] = 'Vaš izlaz';
$string['grademethod'] = 'Ocena';
$string['grademethod_all'] = 'Puni bodovi samo kad prođu svi testovi';
$string['grademethod_proportional'] = 'Udeo testova koji su prošli, po njihovoj težini';
$string['gradingnote'] = 'Uz testove se odgovor ocenjuje automatski: algoritam se izvršava na ulazima svakog testa, a izlaz se poredi sa izlazom vašeg rešenja. Bez testova odgovor ocenjujete ručno.';
$string['growth_o1'] = '1 (konstantno)';
$string['growth_ologn'] = 'log n';
$string['growth_on'] = 'n (linearno)';
$string['growth_on2'] = 'n² (kvadratno)';
$string['growth_on3'] = 'n³ (kubno)';
$string['growth_onlogn'] = 'n log n';
$string['hiddentest'] = 'Skriven test';
$string['hidetools'] = 'Sakrij generisani kôd i uvoz i izvoz datoteka';
$string['hidetools_help'] = 'Učenici u editoru tokom pokušaja ne vide panel koda, uvoz i izvoz .fprg datoteka ni dugmad za slike. Ovo odvraća od prepisivanja koda iz dijagrama (ili dijagrama iz datoteke), ali ništa ne zaključava. Pregled posle pokušaja prikazuje kôd kao i obično.';
$string['ignorecase'] = 'Velika i mala slova se ne razlikuju';
$string['ignorespaces'] = 'Višak razmaka se ne računa';
$string['inputs'] = 'Ulaz';
$string['maxblocks'] = 'Najviše blokova';
$string['maxblocks_help'] = 'Odgovor može imati najviše ovoliko blokova u svim funkcijama (0: bez ograničenja). Kratko rešenje je često i jasnije.';
$string['maxblocksnegative'] = 'Broj blokova ne može biti negativan.';
$string['maxgrowth'] = 'Broj koraka sme da raste najviše kao';
$string['maxgrowth_help'] = 'Odgovor se izvršava za n = 10, 20, 50, 100, 200 i 500, broje se njegovi koraci, a rast koji im najbolje odgovara ne sme biti brži od ovde izabranog (Složenost u editoru meri na isti način). Veličina n je dodela celog broja kao n = 10 u glavnoj funkciji, a inače prva vrednost koju algoritam učita; ostale vrednosti koje učitava su slučajni celi brojevi.';
$string['maxgrowth_none'] = 'Bez ograničenja';
$string['missingstructures'] = 'Algoritam mora da koristi: {$a}. Odgovor ne dobija bodove.';
$string['noalgorithm'] = 'Algoritam nije predat.';
$string['noinput'] = 'Algoritam traži više ulaza nego što test sadrži.';
$string['nosolution'] = 'Nacrtajte rešenje: iz njega se računaju očekivani izlazi testova.';
$string['numbers'] = 'Samo brojevi (tekst oko njih može biti bilo kakav)';
$string['numbers_help'] = 'Porede se samo brojevi iz izlaza, redom, pa učenici oko njih mogu da napišu bilo kakav tekst. Uz „Samo ispis posle poslednjeg unosa“ ne računaju se ni poruke poput „Unesi broj“.';
$string['parsons'] = 'Parsonsov zadatak';
$string['parsons_desc'] = 'Učenici dobijaju blokove rešenja izmešane i slažu ih';
$string['parsons_help'] = 'Učenici ne crtaju algoritam: dobijaju sve blokove rešenja, izmešane, sa praznim petljama i grananjima, i premeštaju blokove na njihova mesta. Ne mogu da dodaju blokove niti da menjaju njihov tekst. Odgovor se ocenjuje testovima, kao i svaki drugi. Početni šablon se ne koristi.';
$string['parsonsintro'] = 'Složi date blokove: premesti svaki blok na njegovo mesto (i u petlje i grananja) i obriši blokove koji ne pripadaju.';
$string['passed'] = 'Prošao';
$string['pleasedrawalgorithm'] = 'Nacrtajte algoritam: dodajte bar jedan blok.';
$string['pluginname'] = 'Algoritam';
$string['pluginname_help'] = 'Student u pitanju crta algoritam kao dijagram toka i može ga pokrenuti. Uz testove se odgovor ocenjuje automatski, a bez testova ga ocenjuje nastavnik.';
$string['pluginnameadding'] = 'Dodavanje pitanja tipa Algoritam';
$string['pluginnameediting'] = 'Izmena pitanja tipa Algoritam';
$string['pluginnamesummary'] = 'Student crta algoritam kao dijagram toka i može ga pokrenuti. Ocenjuje se automatski, testovima čiji se izlazi računaju iz rešenja nastavnika, ili ručno.';
$string['privacy:metadata'] = 'Tip pitanja Algoritam ne čuva lične podatke. Odgovore čuva Moodle sistem za pitanja. Pregledač u svom lokalnom skladištu čuva nekoliko podešavanja prikaza (da li su kod i promenljive prikazani).';
$string['responsesummary'] = 'Algoritam sa {$a->blocks} blokova u {$a->functions} funkcija';
$string['rule_aihints'] = 'Posle greške ili neuspelog testa možete da zatražite AI pomoć; ona ne daje rešenje.';
$string['rule_ignorecase'] = 'Velika i mala slova se ne razlikuju.';
$string['rule_ignorespaces'] = 'Višak razmaka se ne računa.';
$string['rule_maxblocks'] = 'Najviše {$a} blokova.';
$string['rule_maxgrowth'] = 'Broj koraka sme da raste najviše kao {$a}.';
$string['rule_numbers'] = 'Testovi porede samo brojeve koje algoritam ispisuje, redom.';
$string['rule_numbersafter'] = 'Testovi porede samo brojeve koje algoritam ispisuje posle poslednjeg unosa, redom; tekst oko njih može biti bilo kakav.';
$string['rule_stepfactor'] = 'U svakom testu najviše {$a} puta više koraka od nastavnikovog rešenja.';
$string['rule_structures'] = 'Algoritam mora da koristi: {$a}.';
$string['rule_text'] = 'Testovi porede sve što algoritam ispisuje.';
$string['rule_textafter'] = 'Testovi porede ono što algoritam ispisuje posle poslednjeg unosa.';
$string['rule_tolerance'] = 'Brojevi smeju da se razlikuju za {$a}.';
$string['showtests'] = 'Testovi u pokušaju';
$string['showtests_desc'] = 'Učenici mogu da pokreću testove koji nisu skriveni dok rade';
$string['solution'] = 'Rešenje';
$string['solutionandtests'] = 'Rešenje i testovi';
$string['solutionblocks'] = 'Rešenje ima {$a} blokova, više od ovog ograničenja.';
$string['solutionfails'] = 'Rešenje ne radi na testu {$a->n}: {$a->error}';
$string['solutiongrowth'] = 'Broj koraka rešenja raste kao {$a}, brže od ovog ograničenja.';
$string['solutionnogrowth'] = 'Rast rešenja ne može da se izmeri: potrebna je veličina n (dodela kao n = 10, ili prvi unos) i rešenje mora da radi za n = 10, 20 i 50.';
$string['stepfactor'] = 'Koraci u odnosu na rešenje';
$string['stepfactor_help'] = 'Odgovor sme da napravi najviše ovoliko puta više koraka od nastavnikovog rešenja u svakom testu (0: bez ograničenja). Sa 1.5 odgovoru sme da treba upola više koraka od rešenja. Korak je jedan izvršen blok, kao u brojaču koraka u editoru.';
$string['stepfactorrange'] = 'Upišite 0 za bez ograničenja, ili broj od 1 naviše.';
$string['structure_array'] = 'niz';
$string['structure_dowhile'] = 'Do petlja';
$string['structure_for'] = 'For petlja';
$string['structure_if'] = 'If (grananje)';
$string['structure_matrix'] = 'matrica';
$string['structure_while'] = 'While petlja';
$string['structures'] = 'Obavezne strukture';
$string['structures_help'] = 'Ako odgovor ne koristi svaku ovde označenu strukturu, ne dobija bodove, čak i kad testovi prođu.';
$string['studenteditor'] = 'Editor za učenike';
$string['template'] = 'Početni šablon';
$string['test'] = 'Test';
$string['testerror'] = 'Test {$a}: prekinut greškom';
$string['testfailed'] = 'Test {$a}: drugačiji ispis';
$string['testpassed'] = 'Test {$a}: prošao';
$string['tests'] = 'Testovi';
$string['tests_help'] = 'Dodajte testove i upišite ulaze, jednu vrednost po redu ("" za praznu vrednost). Test može i da pozove jednu od funkcija algoritma: izaberite funkciju i upišite argumente, na primer 2, 3; poredi se vrednost koju vrati. Očekivani izlazi se računaju iz vašeg rešenja kad sačuvate pitanje. Svaki test ima težinu (1 ako je ne promenite): test sa težinom 2 vredi dvostruko. Skriveni testovi se ocenjuju, ali učenici ne vide njihove ulaze i izlaze.';
$string['testssummary'] = 'Prošlo testova: {$a->passed} od {$a->total}';
$string['tolerance'] = 'Tolerancija za brojeve';
$string['tolerance_help'] = 'Brojevi u ispisu smeju da se razlikuju od očekivanih najviše za ovoliko, na primer 0.01. Ostatak reda mora biti isti. 0 poredi brojeve tačno.';
$string['tolerancenegative'] = 'Tolerancija ne može biti negativna.';
$string['toolarge'] = 'Algoritam je prevelik: može da ima najviše {$a} blokova.';
$string['usetemplate'] = 'Učenici počinju od posebnog šablona umesto od praznog dijagrama';
$string['weight'] = 'Težina';
