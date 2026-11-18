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
 * Strings for component 'qtype_algorithm', language 'hr' (Croatian).
 *
 * @package    qtype_algorithm
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['afterinput'] = 'Samo ispis poslije posljednjeg unosa';
$string['aihints'] = 'AI pomoć';
$string['aihints_desc'] = 'Uz AI pružatelja sustava (Administracija sustava, Općenito, AI) učenici mogu zatražiti pomoć kada se njihov algoritam zaustavi s greškom ili test ne prođe. Umjetna inteligencija dobiva algoritam kao pseudokod i grešku ili test, uz uputu da nikada ne daje rješenje. U testovima to dopuštaju samo pitanja s uključenom opcijom AI pomoć. Zadano isključeno.';
$string['aihints_help'] = 'Kada je AI pomoć uključena u postavkama dodatka Algoritam (dijagram toka) i sustav ima AI pružatelja, učenici u pokušaju dobivaju gumbe Objasni uz AI (poslije greške) i AI pomoć (pored neuspjelog testa). Umjetna inteligencija dobiva učenikov algoritam kao pseudokod, grešku ili vidljivi test i tekst pitanja, uz uputu da nikada ne daje rješenje. Na ispitima je ostavite isključenu.';
$string['answerlegend'] = 'Vaš algoritam';
$string['cachedef_results'] = 'Rezultati testova odgovora s algoritmom';
$string['compare'] = 'Što se uspoređuje';
$string['copyfromsolution'] = 'Kopiraj iz rješenja';
$string['correctsolution'] = 'Rješenje nastavnika:';
$string['distractors'] = 'Dodatni pogrešni blokovi';
$string['distractors_help'] = 'Blokovi napravljeni od blokova rješenja s malom greškom (< umjesto <=, - 1 umjesto + 1, or umjesto and, broj veći za jedan). Učenici ih trebaju izostaviti.';
$string['efficiency'] = 'Učinkovitost';
$string['efficiency_blocks'] = 'Algoritam ima {$a->blocks} blokova; dopušteno je najviše {$a->max}.';
$string['efficiency_growth'] = 'Broj koraka algoritma raste kao {$a->growth}; dopušteno je najviše {$a->max}.';
$string['efficiency_growthunknown'] = 'Rast algoritma nije mogao se izmjeriti: potrebna je veličina n (dodjela kao n = 10, ili prvi unos) i algoritam mora raditi za n = 10, 20 i 50.';
$string['efficiency_steps'] = 'Test {$a->n}: algoritam je napravio {$a->steps} koraka; dopušteno je najviše {$a->max}.';
$string['efficiencypenalty'] = 'Umanjenje za odgovor koji nije dovoljno učinkovit (%)';
$string['efficiencypenalty_help'] = 'Kada odgovor prolazi testove, ali ne ispunjava uvjet učinkovitosti (koraci, rast ili blokovi), ovoliko postotaka se oduzima od ocjene. 100 ne daje poene takvom odgovoru, 0 samo prikazuje poruku.';
$string['efficiencypenaltyapplied'] = 'Zbog toga se od ocjene oduzima {$a} %.';
$string['efficiencypenaltyrange'] = 'Umanjenje je postotak od 0 do 100.';
$string['emptytemplate'] = 'Prazan';
$string['expected'] = 'Očekivano';
$string['failed'] = 'Nije prošao';
$string['gaps'] = 'Popuni praznine';
$string['gaps_help'] = 'Kad je veće od 0, učenici ne crtaju algoritam: dobivaju rješenje u kojem je toliko izraza i uvjeta ispražnjeno (odabranih nasumično na početku pokušaja) i upisuju samo dijelove koji nedostaju. Blokovi se ne dodaju, ne premještaju i ne brišu. Odgovor se ocjenjuje testovima. Ne koristi se u Parsonsovom zadatku.';
$string['gapsintro'] = 'Popuni praznine: upiši izraze koji nedostaju u blokove označene prazninom (___). Blokovi ostaju gdje jesu.';
$string['got'] = 'Vaš izlaz';
$string['grademethod'] = 'Ocjena';
$string['grademethod_all'] = 'Puni bodovi samo kad prođu svi testovi';
$string['grademethod_proportional'] = 'Udio testova koji su prošli, po njihovoj težini';
$string['gradingnote'] = 'Uz testove se odgovor ocjenjuje automatski: algoritam se izvršava na ulazima svakog testa, a izlaz se uspoređuje s izlazom vašeg rješenja. Bez testova odgovor ocjenjujete ručno.';
$string['growth_o1'] = '1 (konstantno)';
$string['growth_ologn'] = 'log n';
$string['growth_on'] = 'n (linearno)';
$string['growth_on2'] = 'n² (kvadratno)';
$string['growth_on3'] = 'n³ (kubno)';
$string['growth_onlogn'] = 'n log n';
$string['hiddentest'] = 'Skriven test';
$string['hidetools'] = 'Sakrij generirani kôd i uvoz i izvoz datoteka';
$string['hidetools_help'] = 'Učenici u uređivaču tijekom pokušaja ne vide panel koda, uvoz i izvoz .fprg datoteka ni gumbe za slike. Ovo odvraća od prepisivanja koda iz dijagrama (ili dijagrama iz datoteke), ali ništa ne zaključava. Pregled poslije pokušaja prikazuje kôd kao i obično.';
$string['ignorecase'] = 'Velika i mala slova se ne razlikuju';
$string['ignorespaces'] = 'Višak razmaka se ne računa';
$string['inputs'] = 'Ulaz';
$string['maxblocks'] = 'Najviše blokova';
$string['maxblocks_help'] = 'Odgovor može imati najviše ovoliko blokova u svim funkcijama (0: bez ograničenja). Kratko rješenje je često i jasnije.';
$string['maxblocksnegative'] = 'Broj blokova ne može biti negativan.';
$string['maxgrowth'] = 'Broj koraka smije rasti najviše kao';
$string['maxgrowth_help'] = 'Odgovor se izvršava za n = 10, 20, 50, 100, 200 i 500, broje se njegovi koraci, a rast koji im najbolje odgovara ne smije biti brži od ovdje izabranog (Složenost u uređivaču mjeri na isti način). Veličina n je dodjela cijelog broja kao n = 10 u glavnoj funkciji, a inače prva vrijednost koju algoritam učita; ostale vrijednosti koje učitava su slučajni cijeli brojevi.';
$string['maxgrowth_none'] = 'Bez ograničenja';
$string['missingstructures'] = 'Algoritam mora koristiti: {$a}. Odgovor ne dobiva bodove.';
$string['noalgorithm'] = 'Algoritam nije predat.';
$string['noinput'] = 'Algoritam traži više ulaza nego što test sadrži.';
$string['nosolution'] = 'Nacrtajte rješenje: iz njega se računaju očekivani izlazi testova.';
$string['numbers'] = 'Samo brojevi (tekst oko njih može biti bilo kakav)';
$string['numbers_help'] = 'Uspoređuju se samo brojevi iz izlaza, redom, pa učenici oko njih mogu napisati bilo kakav tekst. Uz „Samo ispis poslije posljednjeg unosa“ ne računaju se ni poruke poput „Unesi broj“.';
$string['ordercheck'] = 'Provjera redoslijeda';
$string['ordercheck_desc'] = 'Učenici mogu provjeriti redoslijed svojih blokova';
$string['ordercheck_help'] = 'Učenici dobivaju gumb Provjeri redoslijed: označi blokove koji nisu na svom mjestu (u pogrešnoj petlji ili grani, pogrešnim redom ili višak pogrešnih blokova) bez pokretanja algoritma. Rješenje se ne prikazuje. Provjera ne nosi kaznu, zato je koristite za vježbu.';
$string['parsons'] = 'Parsonsov zadatak';
$string['parsons_desc'] = 'Učenici dobivaju blokove rješenja izmiješane i slažu ih';
$string['parsons_help'] = 'Učenici ne crtaju algoritam: dobivaju sve blokove rješenja, izmiješane, s praznim petljama i grananjima, i premještaju blokove na njihova mjesta. Ne mogu dodati blokove niti mijenjati njihov tekst. Odgovor se ocjenjuje testovima, kao i svaki drugi. Početni predložak se ne koristi.';
$string['parsonsintro'] = 'Složi zadane blokove: premjesti svaki blok na njegovo mjesto (i u petlje i grananja) i izbriši blokove koji ne pripadaju.';
$string['passed'] = 'Prošao';
$string['pleasedrawalgorithm'] = 'Nacrtajte algoritam: dodajte barem jedan blok.';
$string['pluginname'] = 'Algoritam';
$string['pluginname_help'] = 'Student u pitanju crta algoritam kao dijagram toka i može ga pokrenuti. Uz testove se odgovor ocjenjuje automatski, a bez testova ga ocjenjuje nastavnik.';
$string['pluginnameadding'] = 'Dodavanje pitanja tipa Algoritam';
$string['pluginnameediting'] = 'Izmjena pitanja tipa Algoritam';
$string['pluginnamesummary'] = 'Student crta algoritam kao dijagram toka i može ga pokrenuti. Ocjenjuje se automatski, testovima čiji se izlazi računaju iz rješenja nastavnika, ili ručno.';
$string['privacy:metadata'] = 'Tip pitanja Algoritam ne čuva osobne podatke. Odgovore čuva Moodle sustav za pitanja. Preglednik u svom lokalnom spremištu čuva nekoliko postavki prikaza (jesu li kod i varijable prikazani).';
$string['responsesummary'] = 'Algoritam s {$a->blocks} blokova u {$a->functions} funkcija';
$string['rule_aihints'] = 'Poslije greške ili neuspjelog testa možete zatražiti AI pomoć; ona ne daje rješenje.';
$string['rule_ignorecase'] = 'Velika i mala slova se ne razlikuju.';
$string['rule_ignorespaces'] = 'Višak razmaka se ne računa.';
$string['rule_maxblocks'] = 'Najviše {$a} blokova.';
$string['rule_maxgrowth'] = 'Broj koraka smije rasti najviše kao {$a}.';
$string['rule_numbers'] = 'Testovi uspoređuju samo brojeve koje algoritam ispisuje, redom.';
$string['rule_numbersafter'] = 'Testovi uspoređuju samo brojeve koje algoritam ispisuje poslije posljednjeg unosa, redom; tekst oko njih može biti bilo kakav.';
$string['rule_stepfactor'] = 'U svakom testu najviše {$a} puta više koraka od nastavnikovog rješenja.';
$string['rule_strictinit'] = 'Svaka varijabla, element niza i polje moraju dobiti vrijednost prije upotrebe.';
$string['rule_structures'] = 'Algoritam mora koristiti: {$a}.';
$string['rule_text'] = 'Testovi uspoređuju sve što algoritam ispisuje.';
$string['rule_textafter'] = 'Testovi uspoređuju ono što algoritam ispisuje poslije posljednjeg unosa.';
$string['rule_tolerance'] = 'Brojevi smiju se razlikovati za {$a}.';
$string['showtests'] = 'Testovi u pokušaju';
$string['showtests_desc'] = 'Učenici mogu pokretati testove koji nisu skriveni dok rade';
$string['solution'] = 'Rješenje';
$string['solutionandtests'] = 'Rješenje i testovi';
$string['solutionblocks'] = 'Rješenje ima {$a} blokova, više od ovog ograničenja.';
$string['solutionfails'] = 'Rješenje ne radi na testu {$a->n}: {$a->error}';
$string['solutiongrowth'] = 'Broj koraka rješenja raste kao {$a}, brže od ovog ograničenja.';
$string['solutionnogrowth'] = 'Rast rješenja ne može se izmjeriti: potrebna je veličina n (dodjela kao n = 10, ili prvi unos) i rješenje mora raditi za n = 10, 20 i 50.';
$string['stepfactor'] = 'Koraci u odnosu na rješenje';
$string['stepfactor_help'] = 'Odgovor smije napraviti najviše ovoliko puta više koraka od nastavnikova rješenja u svakom testu (0: bez ograničenja). S 1.5 odgovor smije imati upola više koraka od rješenja. Korak je jedan izvršeni blok, kao u brojaču koraka u uređivaču.';
$string['stepfactorrange'] = 'Upišite 0 za bez ograničenja, ili broj od 1 naviše.';
$string['strictinit'] = 'Stroga inicijalizacija';
$string['strictinit_desc'] = 'Varijabla mora dobiti vrijednost prije upotrebe';
$string['strictinit_help'] = 'Kao u C, C++ i Javi: čitanje varijable, elementa niza ili polja zapisa prije nego što dobije vrijednost zaustavlja algoritam pogreškom (u učenikovim pokretanjima i pri ocjenjivanju), a generirani kod u C, C++, Javi i C# deklarira varijable bez početne vrijednosti. Bez ove opcije deklarirana varijabla počinje od 0, praznog teksta ili false.';
$string['structure_array'] = 'niz';
$string['structure_dowhile'] = 'Do petlja';
$string['structure_for'] = 'For petlja';
$string['structure_if'] = 'If (grananje)';
$string['structure_matrix'] = 'matrica';
$string['structure_record'] = 'zapis';
$string['structure_while'] = 'While petlja';
$string['structures'] = 'Obavezne strukture';
$string['structures_help'] = 'Ako odgovor ne koristi svaku ovdje označenu strukturu, ne dobiva bodove, čak i kad testovi prođu.';
$string['studenteditor'] = 'Uređivač za učenike';
$string['template'] = 'Početni predložak';
$string['test'] = 'Test';
$string['testerror'] = 'Test {$a}: prekinut greškom';
$string['testfailed'] = 'Test {$a}: drugačiji ispis';
$string['testpassed'] = 'Test {$a}: prošao';
$string['tests'] = 'Testovi';
$string['tests_help'] = 'Dodajte testove i upišite ulaze, jednu vrijednost po retku ("" za praznu vrijednost). Test može i pozvati jednu od funkcija algoritma: odaberite funkciju i upišite argumente, na primjer 2, 3; uspoređuje se vrijednost koju vrati. Očekivani izlazi se računaju iz vašeg rješenja kad spremite pitanje. Svaki test ima težinu (1 ako je ne promijenite): test s težinom 2 vrijedi dvostruko. Skriveni testovi se ocjenjuju, ali učenici ne vide njihove ulaze i izlaze.';
$string['testssummary'] = 'Prošlo testova: {$a->passed} od {$a->total}';
$string['tolerance'] = 'Tolerancija za brojeve';
$string['tolerance_help'] = 'Brojevi u ispisu smiju se razlikovati od očekivanih najviše za ovoliko, na primjer 0.01. Ostatak retka mora biti isti. 0 uspoređuje brojeve točno.';
$string['tolerancenegative'] = 'Tolerancija ne može biti negativna.';
$string['toolarge'] = 'Algoritam je prevelik: može imati najviše {$a} blokova.';
$string['usetemplate'] = 'Učenici počinju od posebnog predloška umjesto od praznog dijagrama';
$string['weight'] = 'Težina';
