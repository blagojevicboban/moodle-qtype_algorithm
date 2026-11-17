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
 * Strings for component 'qtype_algorithm', language 'sl' (Slovenian).
 *
 * @package    qtype_algorithm
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['afterinput'] = 'Samo izpis po zadnjem vnosu';
$string['aihints'] = 'Namigi UI';
$string['aihints_desc'] = 'Učenci lahko UI spletnega mesta prosijo za namige o napakah in neuspelih testih';
$string['aihints_help'] = 'Ko so namigi UI vklopljeni v nastavitvah vtičnika Urejevalnik algoritmov in ima spletno mesto ponudnika UI, imajo učenci v poskusu gumba Razloži z UI (po napaki) in Namig UI (ob neuspelem testu). UI prejme učenčev algoritem kot psevdokodo, napako ali vidni test in besedilo vprašanja ter navodilo, naj nikoli ne izda rešitve. Pri izpitih naj ostane izklopljeno.';
$string['answerlegend'] = 'Vaš algoritem';
$string['cachedef_results'] = 'Rezultati testov odgovorov Algoritem';
$string['compare'] = 'Kaj se primerja';
$string['copyfromsolution'] = 'Kopiraj iz rešitve';
$string['correctsolution'] = 'Učiteljeva rešitev:';
$string['distractors'] = 'Dodatni napačni bloki';
$string['distractors_help'] = 'Bloki, narejeni iz blokov rešitve z majhno napako (< namesto <=, - 1 namesto + 1, or namesto and, število, večje za ena). Učenci jih morajo izpustiti.';
$string['efficiency'] = 'Učinkovitost';
$string['efficiency_blocks'] = 'Algoritem ima {$a->blocks} blokov; dovoljenih je največ {$a->max}.';
$string['efficiency_growth'] = 'Koraki algoritma rastejo kot {$a->growth}; dovoljeno je največ {$a->max}.';
$string['efficiency_growthunknown'] = 'Rasti algoritma ni bilo mogoče izmeriti: potrebuje velikost n (prireditev, kot je n = 10, ali prvi vnos) in se mora izvesti za n = 10, 20 in 50.';
$string['efficiency_steps'] = 'Test {$a->n}: algoritem je naredil {$a->steps} korakov; dovoljenih je največ {$a->max}.';
$string['efficiencypenalty'] = 'Odbitek za odgovor, ki ni dovolj učinkovit (%)';
$string['efficiencypenalty_help'] = 'Ko odgovor opravi teste, vendar krši pogoj učinkovitosti (koraki, rast ali bloki), se ta odstotek odšteje od njegove ocene. 100 takemu odgovoru ne da točk, 0 le prikaže sporočilo.';
$string['efficiencypenaltyapplied'] = 'Zato se od ocene odšteje {$a} %.';
$string['efficiencypenaltyrange'] = 'Odbitek je odstotek od 0 do 100.';
$string['emptytemplate'] = 'Prazno';
$string['expected'] = 'Pričakovano';
$string['failed'] = 'Ni opravljen';
$string['got'] = 'Vaš izpis';
$string['grademethod'] = 'Ocena';
$string['grademethod_all'] = 'Polno število točk le, ko so opravljeni vsi testi';
$string['grademethod_proportional'] = 'Delež opravljenih testov glede na njihovo težo';
$string['gradingnote'] = 'S testi se odgovor oceni samodejno: algoritem se izvede z vhodi vsakega testa, njegov izpis pa se primerja z izpisom vaše rešitve. Brez testov odgovor ocenite ročno.';
$string['growth_o1'] = '1 (konstantna)';
$string['growth_ologn'] = 'log n';
$string['growth_on'] = 'n (linearna)';
$string['growth_on2'] = 'n² (kvadratna)';
$string['growth_on3'] = 'n³ (kubična)';
$string['growth_onlogn'] = 'n log n';
$string['hiddentest'] = 'Skriti test';
$string['hidetools'] = 'Skrij ustvarjeno kodo ter uvoz in izvoz datotek';
$string['hidetools_help'] = 'Učenci v urejevalniku poskusa ne vidijo podokna kode, uvoza in izvoza .fprg ali gumbov za slike. To odvrača od prepisovanja kode iz diagrama (ali diagrama iz datoteke); ničesar ne zaklene. Pregled po poskusu prikaže kodo kot običajno.';
$string['ignorecase'] = 'Velike in male črke so enake';
$string['ignorespaces'] = 'Odvečni presledki ne štejejo';
$string['inputs'] = 'Vhod';
$string['maxblocks'] = 'Največ blokov';
$string['maxblocks_help'] = 'Odgovor ima lahko v vseh svojih funkcijah največ toliko blokov (0: brez omejitve). Kratka rešitev je pogosto bolj jasna.';
$string['maxblocksnegative'] = 'Število blokov ne more biti negativno.';
$string['maxgrowth'] = 'Koraki smejo rasti največ kot';
$string['maxgrowth_help'] = 'Odgovor se izvede za n = 10, 20, 50, 100, 200 in 500, njegovi koraki se preštejejo, rast, ki se jim najbolje prilega, pa ne sme biti hitrejša od tukaj izbrane (Kompleksnost v urejevalniku meri enako). Velikost n je prireditev celega števila, kot je n = 10, v glavni funkciji, sicer pa prva vrednost, ki jo algoritem prebere; druge prebrane vrednosti so naključna cela števila.';
$string['maxgrowth_none'] = 'Brez omejitve';
$string['missingstructures'] = 'Algoritem mora uporabiti: {$a}. Odgovor ne dobi točk.';
$string['noalgorithm'] = 'Algoritem ni bil oddan.';
$string['noinput'] = 'Algoritem zahteva več vhodov, kot jih da test.';
$string['nosolution'] = 'Narišite rešitev: pričakovani izpisi testov se izračunajo iz nje.';
$string['numbers'] = 'Samo števila (besedilo okoli njih je lahko poljubno)';
$string['numbers_help'] = 'Primerjajo se samo števila v izpisu, po vrsti, zato lahko učenci okoli njih napišejo poljubno besedilo. Pri možnosti »Samo izpis po zadnjem vnosu« ne štejejo niti pozivi, kot je »Vnesi število«.';
$string['parsons'] = 'Parsonsova naloga';
$string['parsons_desc'] = 'Učenci dobijo bloke rešitve v naključnem vrstnem redu in jih razvrstijo';
$string['parsons_help'] = 'Učenci algoritma ne rišejo: dobijo vse bloke rešitve v naključnem vrstnem redu, s praznimi zankami in vejami, in bloke premaknejo na njihova mesta. Ne morejo dodajati blokov ali spreminjati njihovega besedila. Odgovor se oceni s testi, kot vsak drug. Začetna predloga se ne uporabi.';
$string['parsonsintro'] = 'Razvrstite dane bloke: vsak blok premaknite na njegovo mesto (tudi v zanke in veje) in izbrišite bloke, ki ne sodijo zraven.';
$string['passed'] = 'Opravljen';
$string['pleasedrawalgorithm'] = 'Narišite algoritem: dodajte vsaj en blok.';
$string['pluginname'] = 'Algoritem';
$string['pluginname_help'] = 'Učenec v vprašanju nariše algoritem kot diagram poteka in ga lahko zažene. S testi se odgovor oceni samodejno; brez testov ga oceni učitelj.';
$string['pluginnameadding'] = 'Dodajanje vprašanja Algoritem';
$string['pluginnameediting'] = 'Urejanje vprašanja Algoritem';
$string['pluginnamesummary'] = 'Učenec nariše algoritem kot diagram poteka in ga lahko zažene. Ocenjeno samodejno s testi, izračunanimi iz učiteljeve rešitve, ali ročno.';
$string['privacy:metadata'] = 'Vrsta vprašanja Algoritem ne hrani osebnih podatkov. Odgovore hrani Moodlov pogon za vprašanja. Brskalnik v svoji lokalni shrambi hrani nekaj nastavitev prikaza (ali sta koda in spremenljivke prikazani ali skriti).';
$string['responsesummary'] = 'Algoritem z blokov: {$a->blocks} v funkcijah: {$a->functions}';
$string['rule_aihints'] = 'Po napaki ali neuspelem testu lahko UI prosite za namig; rešitve ne izda.';
$string['rule_ignorecase'] = 'Velike in male črke so enake.';
$string['rule_ignorespaces'] = 'Odvečni presledki ne štejejo.';
$string['rule_maxblocks'] = 'Največ {$a} blokov.';
$string['rule_maxgrowth'] = 'Koraki smejo rasti največ kot {$a}.';
$string['rule_numbers'] = 'Testi primerjajo samo števila, ki jih izpiše vaš algoritem, po vrsti.';
$string['rule_numbersafter'] = 'Testi primerjajo samo števila, ki jih vaš algoritem izpiše po zadnjem vnosu, po vrsti; besedilo okoli njih je lahko poljubno.';
$string['rule_stepfactor'] = 'V vsakem testu največ {$a}-krat toliko korakov kot učiteljeva rešitev.';
$string['rule_structures'] = 'Algoritem mora uporabiti: {$a}.';
$string['rule_text'] = 'Testi primerjajo vse, kar izpiše vaš algoritem.';
$string['rule_textafter'] = 'Testi primerjajo, kar vaš algoritem izpiše po zadnjem vnosu.';
$string['rule_tolerance'] = 'Števila se lahko razlikujejo za {$a}.';
$string['showtests'] = 'Testi v poskusu';
$string['showtests_desc'] = 'Učenci lahko med delom zaženejo teste, ki niso skriti';
$string['solution'] = 'Rešitev';
$string['solutionandtests'] = 'Rešitev in testi';
$string['solutionblocks'] = 'Rešitev ima {$a} blokov, več kot ta omejitev.';
$string['solutionfails'] = 'Rešitev ne opravi testa {$a->n}: {$a->error}';
$string['solutiongrowth'] = 'Koraki rešitve rastejo kot {$a}, hitreje od te omejitve.';
$string['solutionnogrowth'] = 'Rasti rešitve ni mogoče izmeriti: potrebuje velikost n (prireditev, kot je n = 10, ali prvi vnos) in se mora izvesti za n = 10, 20 in 50.';
$string['stepfactor'] = 'Koraki v primerjavi z rešitvijo';
$string['stepfactor_help'] = 'Odgovor sme v vsakem testu narediti največ tolikokrat toliko korakov kot učiteljeva rešitev (0: brez omejitve). Pri 1.5 sme odgovor potrebovati za polovico več korakov kot rešitev. Korak je en izveden blok, kot v števcu korakov urejevalnika.';
$string['stepfactorrange'] = 'Uporabite 0 za brez omejitve ali število od 1 naprej.';
$string['structure_array'] = 'tabela';
$string['structure_dowhile'] = 'Zanka Ponavljaj';
$string['structure_for'] = 'Zanka Za';
$string['structure_if'] = 'Če';
$string['structure_matrix'] = 'matrika';
$string['structure_record'] = 'zapis';
$string['structure_while'] = 'Zanka Dokler';
$string['structures'] = 'Zahtevane strukture';
$string['structures_help'] = 'Če odgovor ne uporabi vsake tukaj označene strukture, ne dobi točk, tudi če opravi teste.';
$string['studenteditor'] = 'Urejevalnik za učence';
$string['template'] = 'Začetna predloga';
$string['test'] = 'Test';
$string['testerror'] = 'Test {$a}: ustavljen z napako';
$string['testfailed'] = 'Test {$a}: drugačen izpis';
$string['testpassed'] = 'Test {$a}: opravljen';
$string['tests'] = 'Testi';
$string['tests_help'] = 'Dodajte teste in vnesite njihove vhode, eno vrednost v vrstico ("" za prazno vrednost). Test lahko pokliče tudi eno od funkcij algoritma: izberite funkcijo in vnesite njene argumente, na primer 2, 3; primerja se vrednost, ki jo vrne. Pričakovani izpisi se izračunajo iz vaše rešitve, ko vprašanje shranite. Vsak test ima težo (1, če je ne spremenite): test s težo 2 šteje dvojno. Skriti testi se ocenijo, vendar učenci ne vidijo njihovih vhodov in izpisov.';
$string['testssummary'] = 'Opravljeni testi: {$a->passed} od {$a->total}';
$string['tolerance'] = 'Toleranca za števila';
$string['tolerance_help'] = 'Števila v izpisu se lahko od pričakovanih razlikujejo največ za toliko, na primer 0.01. Ostanek vrstice mora biti enak. 0 primerja števila natančno.';
$string['tolerancenegative'] = 'Toleranca ne more biti negativna.';
$string['toolarge'] = 'Algoritem je prevelik: ima lahko največ {$a} blokov.';
$string['usetemplate'] = 'Učenci začnejo iz posebne predloge namesto iz praznega diagrama';
$string['weight'] = 'Teža';
