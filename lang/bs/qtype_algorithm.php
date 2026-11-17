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
 * Strings for component 'qtype_algorithm', language 'bs' (Bosnian).
 *
 * @package    qtype_algorithm
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['afterinput'] = 'Samo ispis poslije posljednjeg unosa';
$string['aihints'] = 'AI pomoć';
$string['aihints_desc'] = 'Učenici mogu da zatraže pomoć od vještačke inteligencije sajta za greške i neuspjele testove';
$string['aihints_help'] = 'Kada je AI pomoć uključena u podešavanjima dodatka Algoritam (dijagram toka) i sajt ima AI provajdera, učenici u pokušaju dobijaju dugmad Objasni uz AI (poslije greške) i AI pomoć (pored neuspjelog testa). Vještačka inteligencija dobija učenički algoritam kao pseudo-kod, grešku ili vidljivi test i tekst pitanja, uz uputstvo da nikada ne da rješenje. Na ispitima je ostavite isključenu.';
$string['answerlegend'] = 'Vaš algoritam';
$string['cachedef_results'] = 'Rezultati testova odgovora sa algoritmom';
$string['compare'] = 'Šta se poredi';
$string['copyfromsolution'] = 'Kopiraj iz rješenja';
$string['correctsolution'] = 'Rješenje nastavnika:';
$string['distractors'] = 'Dodatni pogrešni blokovi';
$string['distractors_help'] = 'Blokovi napravljeni od blokova rješenja sa malom greškom (< umjesto <=, - 1 umjesto + 1, or umjesto and, broj veći za jedan). Učenici treba da ih izostave.';
$string['efficiency'] = 'Efikasnost';
$string['efficiency_blocks'] = 'Algoritam ima {$a->blocks} blokova; dozvoljeno je najviše {$a->max}.';
$string['efficiency_growth'] = 'Broj koraka algoritma raste kao {$a->growth}; dozvoljeno je najviše {$a->max}.';
$string['efficiency_growthunknown'] = 'Rast algoritma nije mogao da se izmjeri: potrebna je veličina n (dodjela kao n = 10, ili prvi unos) i algoritam mora da radi za n = 10, 20 i 50.';
$string['efficiency_steps'] = 'Test {$a->n}: algoritam je napravio {$a->steps} koraka; dozvoljeno je najviše {$a->max}.';
$string['efficiencypenalty'] = 'Umanjenje za odgovor koji nije dovoljno efikasan (%)';
$string['efficiencypenalty_help'] = 'Kada odgovor prolazi testove, ali ne ispunjava uslov efikasnosti (koraci, rast ili blokovi), ovoliko procenata se oduzima od ocjene. 100 ne daje poene takvom odgovoru, 0 samo prikazuje poruku.';
$string['efficiencypenaltyapplied'] = 'Zbog toga se od ocjene oduzima {$a} %.';
$string['efficiencypenaltyrange'] = 'Umanjenje je procenat od 0 do 100.';
$string['emptytemplate'] = 'Prazan';
$string['expected'] = 'Očekivano';
$string['failed'] = 'Nije prošao';
$string['got'] = 'Vaš izlaz';
$string['grademethod'] = 'Ocjena';
$string['grademethod_all'] = 'Puni bodovi samo kad prođu svi testovi';
$string['grademethod_proportional'] = 'Udio testova koji su prošli, po njihovoj težini';
$string['gradingnote'] = 'Uz testove se odgovor ocjenjuje automatski: algoritam se izvršava na ulazima svakog testa, a izlaz se poredi sa izlazom vašeg rješenja. Bez testova odgovor ocjenjujete ručno.';
$string['growth_o1'] = '1 (konstantno)';
$string['growth_ologn'] = 'log n';
$string['growth_on'] = 'n (linearno)';
$string['growth_on2'] = 'n² (kvadratno)';
$string['growth_on3'] = 'n³ (kubno)';
$string['growth_onlogn'] = 'n log n';
$string['hiddentest'] = 'Skriven test';
$string['hidetools'] = 'Sakrij generisani kôd i uvoz i izvoz datoteka';
$string['hidetools_help'] = 'Učenici u editoru tokom pokušaja ne vide panel koda, uvoz i izvoz .fprg datoteka ni dugmad za slike. Ovo odvraća od prepisivanja koda iz dijagrama (ili dijagrama iz datoteke), ali ništa ne zaključava. Pregled poslije pokušaja prikazuje kôd kao i obično.';
$string['ignorecase'] = 'Velika i mala slova se ne razlikuju';
$string['ignorespaces'] = 'Višak razmaka se ne računa';
$string['inputs'] = 'Ulaz';
$string['maxblocks'] = 'Najviše blokova';
$string['maxblocks_help'] = 'Odgovor može imati najviše ovoliko blokova u svim funkcijama (0: bez ograničenja). Kratko rješenje je često i jasnije.';
$string['maxblocksnegative'] = 'Broj blokova ne može biti negativan.';
$string['maxgrowth'] = 'Broj koraka smije da raste najviše kao';
$string['maxgrowth_help'] = 'Odgovor se izvršava za n = 10, 20, 50, 100, 200 i 500, broje se njegovi koraci, a rast koji im najbolje odgovara ne smije biti brži od ovdje izabranog (Složenost u editoru mjeri na isti način). Veličina n je dodjela cijelog broja kao n = 10 u glavnoj funkciji, a inače prva vrijednost koju algoritam učita; ostale vrijednosti koje učitava su slučajni cijeli brojevi.';
$string['maxgrowth_none'] = 'Bez ograničenja';
$string['missingstructures'] = 'Algoritam mora da koristi: {$a}. Odgovor ne dobija bodove.';
$string['noalgorithm'] = 'Algoritam nije predat.';
$string['noinput'] = 'Algoritam traži više ulaza nego što test sadrži.';
$string['nosolution'] = 'Nacrtajte rješenje: iz njega se računaju očekivani izlazi testova.';
$string['numbers'] = 'Samo brojevi (tekst oko njih može biti bilo kakav)';
$string['numbers_help'] = 'Porede se samo brojevi iz izlaza, redom, pa učenici oko njih mogu da napišu bilo kakav tekst. Uz „Samo ispis poslije posljednjeg unosa“ ne računaju se ni poruke poput „Unesi broj“.';
$string['parsons'] = 'Parsonsov zadatak';
$string['parsons_desc'] = 'Učenici dobijaju blokove rješenja izmiješane i slažu ih';
$string['parsons_help'] = 'Učenici ne crtaju algoritam: dobijaju sve blokove rješenja, izmiješane, sa praznim petljama i grananjima, i premještaju blokove na njihova mjesta. Ne mogu da dodaju blokove niti da mijenjaju njihov tekst. Odgovor se ocjenjuje testovima, kao i svaki drugi. Početni šablon se ne koristi.';
$string['parsonsintro'] = 'Složi date blokove: premjesti svaki blok na njegovo mjesto (i u petlje i grananja) i obriši blokove koji ne pripadaju.';
$string['passed'] = 'Prošao';
$string['pleasedrawalgorithm'] = 'Nacrtajte algoritam: dodajte bar jedan blok.';
$string['pluginname'] = 'Algoritam';
$string['pluginname_help'] = 'Student u pitanju crta algoritam kao dijagram toka i može ga pokrenuti. Uz testove se odgovor ocjenjuje automatski, a bez testova ga ocjenjuje nastavnik.';
$string['pluginnameadding'] = 'Dodavanje pitanja tipa Algoritam';
$string['pluginnameediting'] = 'Izmjena pitanja tipa Algoritam';
$string['pluginnamesummary'] = 'Student crta algoritam kao dijagram toka i može ga pokrenuti. Ocjenjuje se automatski, testovima čiji se izlazi računaju iz rješenja nastavnika, ili ručno.';
$string['privacy:metadata'] = 'Tip pitanja Algoritam ne čuva lične podatke. Odgovore čuva Moodle sistem za pitanja. Preglednik u svom lokalnom skladištu čuva nekoliko podešavanja prikaza (da li su kod i promjenljive prikazani).';
$string['responsesummary'] = 'Algoritam sa {$a->blocks} blokova u {$a->functions} funkcija';
$string['rule_aihints'] = 'Poslije greške ili neuspjelog testa možete da zatražite AI pomoć; ona ne daje rješenje.';
$string['rule_ignorecase'] = 'Velika i mala slova se ne razlikuju.';
$string['rule_ignorespaces'] = 'Višak razmaka se ne računa.';
$string['rule_maxblocks'] = 'Najviše {$a} blokova.';
$string['rule_maxgrowth'] = 'Broj koraka smije da raste najviše kao {$a}.';
$string['rule_numbers'] = 'Testovi porede samo brojeve koje algoritam ispisuje, redom.';
$string['rule_numbersafter'] = 'Testovi porede samo brojeve koje algoritam ispisuje poslije posljednjeg unosa, redom; tekst oko njih može biti bilo kakav.';
$string['rule_stepfactor'] = 'U svakom testu najviše {$a} puta više koraka od nastavnikovog rješenja.';
$string['rule_structures'] = 'Algoritam mora da koristi: {$a}.';
$string['rule_text'] = 'Testovi porede sve što algoritam ispisuje.';
$string['rule_textafter'] = 'Testovi porede ono što algoritam ispisuje poslije posljednjeg unosa.';
$string['rule_tolerance'] = 'Brojevi smiju da se razlikuju za {$a}.';
$string['showtests'] = 'Testovi u pokušaju';
$string['showtests_desc'] = 'Učenici mogu da pokreću testove koji nisu skriveni dok rade';
$string['solution'] = 'Rješenje';
$string['solutionandtests'] = 'Rješenje i testovi';
$string['solutionblocks'] = 'Rješenje ima {$a} blokova, više od ovog ograničenja.';
$string['solutionfails'] = 'Rješenje ne radi na testu {$a->n}: {$a->error}';
$string['solutiongrowth'] = 'Broj koraka rješenja raste kao {$a}, brže od ovog ograničenja.';
$string['solutionnogrowth'] = 'Rast rješenja ne može da se izmjeri: potrebna je veličina n (dodjela kao n = 10, ili prvi unos) i rješenje mora da radi za n = 10, 20 i 50.';
$string['stepfactor'] = 'Koraci u odnosu na rješenje';
$string['stepfactor_help'] = 'Odgovor smije da napravi najviše ovoliko puta više koraka od nastavnikovog rješenja u svakom testu (0: bez ograničenja). Sa 1.5 odgovoru smije da treba upola više koraka od rješenja. Korak je jedan izvršen blok, kao u brojaču koraka u editoru.';
$string['stepfactorrange'] = 'Upišite 0 za bez ograničenja, ili broj od 1 naviše.';
$string['structure_array'] = 'niz';
$string['structure_dowhile'] = 'Do petlja';
$string['structure_for'] = 'For petlja';
$string['structure_if'] = 'If (grananje)';
$string['structure_matrix'] = 'matrica';
$string['structure_record'] = 'zapis';
$string['structure_while'] = 'While petlja';
$string['structures'] = 'Obavezne strukture';
$string['structures_help'] = 'Ako odgovor ne koristi svaku ovdje označenu strukturu, ne dobija bodove, čak i kad testovi prođu.';
$string['studenteditor'] = 'Editor za učenike';
$string['template'] = 'Početni šablon';
$string['test'] = 'Test';
$string['testerror'] = 'Test {$a}: prekinut greškom';
$string['testfailed'] = 'Test {$a}: drugačiji ispis';
$string['testpassed'] = 'Test {$a}: prošao';
$string['tests'] = 'Testovi';
$string['tests_help'] = 'Dodajte testove i upišite ulaze, jednu vrijednost po redu ("" za praznu vrijednost). Test može i da pozove jednu od funkcija algoritma: izaberite funkciju i upišite argumente, na primjer 2, 3; poredi se vrijednost koju vrati. Očekivani izlazi se računaju iz vašeg rješenja kad sačuvate pitanje. Svaki test ima težinu (1 ako je ne promijenite): test sa težinom 2 vrijedi dvostruko. Skriveni testovi se ocjenjuju, ali učenici ne vide njihove ulaze i izlaze.';
$string['testssummary'] = 'Prošlo testova: {$a->passed} od {$a->total}';
$string['tolerance'] = 'Tolerancija za brojeve';
$string['tolerance_help'] = 'Brojevi u ispisu smiju da se razlikuju od očekivanih najviše za ovoliko, na primjer 0.01. Ostatak reda mora biti isti. 0 poredi brojeve tačno.';
$string['tolerancenegative'] = 'Tolerancija ne može biti negativna.';
$string['toolarge'] = 'Algoritam je prevelik: može da ima najviše {$a} blokova.';
$string['usetemplate'] = 'Učenici počinju od posebnog šablona umjesto od praznog dijagrama';
$string['weight'] = 'Težina';
