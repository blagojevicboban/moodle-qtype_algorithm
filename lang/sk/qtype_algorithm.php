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
 * Strings for component 'qtype_algorithm', language 'sk' (Slovak).
 *
 * @package    qtype_algorithm
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['afterinput'] = 'Len výstup po poslednom vstupe';
$string['aihints'] = 'Rady AI';
$string['aihints_desc'] = 'Žiaci môžu požiadať AI stránky o rady k chybám a neúspešným testom';
$string['aihints_help'] = 'Keď sú rady AI zapnuté v nastaveniach doplnku Editor algoritmov a stránka má poskytovateľa AI, žiaci majú v pokuse tlačidlá Vysvetliť s AI (po chybe) a Rada od AI (vedľa neúspešného testu). AI dostane žiakov algoritmus ako pseudokód, chybu alebo viditeľný test a text otázky a má pokyn nikdy neprezradiť riešenie. Na skúškach nechajte vypnuté.';
$string['answerlegend'] = 'Váš algoritmus';
$string['cachedef_results'] = 'Výsledky testov odpovedí typu Algoritmus';
$string['compare'] = 'Čo sa porovnáva';
$string['copyfromsolution'] = 'Kopírovať z riešenia';
$string['correctsolution'] = 'Riešenie učiteľa:';
$string['distractors'] = 'Ďalšie chybné bloky';
$string['distractors_help'] = 'Bloky vytvorené z blokov riešenia s malou chybou (< namiesto <=, - 1 namiesto + 1, or namiesto and, číslo väčšie o jedna). Žiaci ich musia vynechať.';
$string['efficiency'] = 'Efektívnosť';
$string['efficiency_blocks'] = 'Algoritmus má {$a->blocks} blokov; povolených je najviac {$a->max}.';
$string['efficiency_growth'] = 'Kroky algoritmu rastú ako {$a->growth}; povolené je najviac {$a->max}.';
$string['efficiency_growthunknown'] = 'Rast algoritmu sa nepodarilo zmerať: potrebuje veľkosť n (priradenie ako n = 10, alebo prvý vstup) a musí prebehnúť pre n = 10, 20 a 50.';
$string['efficiency_steps'] = 'Test {$a->n}: algoritmus urobil {$a->steps} krokov; povolených je najviac {$a->max}.';
$string['efficiencypenalty'] = 'Zrážka za odpoveď, ktorá nie je dosť efektívna (%)';
$string['efficiencypenalty_help'] = 'Keď odpoveď prejde testami, ale poruší podmienku efektívnosti (kroky, rast alebo bloky), toto percento sa odpočíta z jej hodnotenia. 100 nedá takej odpovedi žiadne body, 0 len zobrazí správu.';
$string['efficiencypenaltyapplied'] = 'Preto sa z hodnotenia odpočíta {$a} %.';
$string['efficiencypenaltyrange'] = 'Zrážka je percento od 0 do 100.';
$string['emptytemplate'] = 'Prázdna';
$string['expected'] = 'Očakávané';
$string['failed'] = 'Neprešiel';
$string['gaps'] = 'Doplniť medzery';
$string['gaps_help'] = 'Ak je viac ako 0, žiaci algoritmus nekreslia: dostanú riešenie s toľkými vyprázdnenými výrazmi a podmienkami (vybranými náhodne na začiatku pokusu) a píšu len chýbajúce časti. Bloky sa nedajú pridávať, presúvať ani mazať. Odpoveď sa hodnotí testami. Nepoužíva sa v Parsonsovej úlohe.';
$string['gapsintro'] = 'Doplň medzery: napíš chýbajúce výrazy do blokov označených medzerou (___). Bloky zostávajú, kde sú.';
$string['got'] = 'Váš výstup';
$string['grademethod'] = 'Hodnotenie';
$string['grademethod_all'] = 'Plný počet bodov len vtedy, keď prejdú všetky testy';
$string['grademethod_proportional'] = 'Podiel prejdených testov podľa ich váhy';
$string['gradingnote'] = 'S testami sa odpoveď hodnotí automaticky: algoritmus prebehne so vstupmi každého testu a jeho výstup sa porovná s výstupom vášho riešenia. Bez testov hodnotíte odpoveď ručne.';
$string['growth_o1'] = '1 (konštantný)';
$string['growth_ologn'] = 'log n';
$string['growth_on'] = 'n (lineárny)';
$string['growth_on2'] = 'n² (kvadratický)';
$string['growth_on3'] = 'n³ (kubický)';
$string['growth_onlogn'] = 'n log n';
$string['hiddentest'] = 'Skrytý test';
$string['hidetools'] = 'Skryť generovaný kód a import a export súborov';
$string['hidetools_help'] = 'Žiaci v editore pokusu nevidia panel kódu, import a export .fprg ani tlačidlá obrázkov. To odrádza od odpisovania kódu z diagramu (alebo diagramu zo súboru); nič to nezamyká. Prehľad po pokuse ukazuje kód ako obvykle.';
$string['ignorecase'] = 'Veľké a malé písmená sú rovnaké';
$string['ignorespaces'] = 'Medzery navyše sa nepočítajú';
$string['inputs'] = 'Vstup';
$string['maxblocks'] = 'Najviac blokov';
$string['maxblocks_help'] = 'Odpoveď môže mať vo všetkých svojich funkciách najviac toľko blokov (0: bez obmedzenia). Krátke riešenie býva prehľadnejšie.';
$string['maxblocksnegative'] = 'Počet blokov nemôže byť záporný.';
$string['maxgrowth'] = 'Kroky smú rásť najviac ako';
$string['maxgrowth_help'] = 'Odpoveď prebehne pre n = 10, 20, 50, 100, 200 a 500, jej kroky sa spočítajú a rast, ktorý im najlepšie zodpovedá, nesmie byť rýchlejší ako tu zvolený (Zložitosť v editore meria rovnako). Veľkosť n je priradenie celého čísla ako n = 10 v hlavnej funkcii, inak prvá hodnota, ktorú algoritmus načíta; ostatné načítané hodnoty sú náhodné celé čísla.';
$string['maxgrowth_none'] = 'Bez obmedzenia';
$string['missingstructures'] = 'Algoritmus musí použiť: {$a}. Odpoveď nedostane žiadne body.';
$string['noalgorithm'] = 'Nebol odoslaný žiadny algoritmus.';
$string['noinput'] = 'Algoritmus žiada viac vstupov, ako test poskytuje.';
$string['nosolution'] = 'Nakreslite riešenie: očakávané výstupy testov sa počítajú z neho.';
$string['numbers'] = 'Len čísla (text okolo nich môže byť ľubovoľný)';
$string['numbers_help'] = 'Porovnávajú sa len čísla vo výstupe, v poradí, takže žiaci okolo nich môžu písať ľubovoľný text. S voľbou „Len výstup po poslednom vstupe“ sa nepočítajú ani výzvy ako „Zadaj číslo“.';
$string['ordercheck'] = 'Kontrola poradia';
$string['ordercheck_desc'] = 'Žiaci môžu skontrolovať poradie svojich blokov';
$string['ordercheck_help'] = 'Žiaci dostanú tlačidlo Skontrolovať poradie: označí bloky, ktoré nie sú na svojom mieste (v nesprávnom cykle alebo vetve, v nesprávnom poradí alebo nadbytočné nesprávne bloky), bez spustenia algoritmu. Riešenie sa nezobrazí. Kontrola nič nestojí, preto ju používajte na precvičovanie.';
$string['parsons'] = 'Parsonsova úloha';
$string['parsons_desc'] = 'Žiaci dostanú bloky riešenia v náhodnom poradí a zoradia ich';
$string['parsons_help'] = 'Žiaci algoritmus nekreslia: dostanú všetky bloky riešenia v náhodnom poradí, s prázdnymi cyklami a vetvami, a presunú bloky na ich miesta. Nemôžu pridávať bloky ani meniť ich text. Odpoveď sa hodnotí testami ako každá iná. Počiatočná šablóna sa nepoužíva.';
$string['parsonsintro'] = 'Zoraďte dané bloky: presuňte každý blok na jeho miesto (aj do cyklov a vetiev) a odstráňte bloky, ktoré tam nepatria.';
$string['passed'] = 'Prešiel';
$string['pleasedrawalgorithm'] = 'Nakreslite algoritmus: pridajte aspoň jeden blok.';
$string['pluginname'] = 'Algoritmus';
$string['pluginname_help'] = 'Žiak v otázke nakreslí algoritmus ako vývojový diagram a môže ho spustiť. S testami sa odpoveď hodnotí automaticky; bez testov ju hodnotí učiteľ.';
$string['pluginnameadding'] = 'Pridanie otázky Algoritmus';
$string['pluginnameediting'] = 'Úprava otázky Algoritmus';
$string['pluginnamesummary'] = 'Žiak nakreslí algoritmus ako vývojový diagram a môže ho spustiť. Hodnotí sa automaticky testami vypočítanými z riešenia učiteľa, alebo ručne.';
$string['privacy:metadata'] = 'Typ otázky Algoritmus neukladá žiadne osobné údaje. Odpovede ukladá jadro otázok Moodle. Prehliadač uchováva vo svojom lokálnom úložisku niekoľko nastavení zobrazenia (či sú kód a premenné zobrazené alebo skryté).';
$string['responsesummary'] = 'Algoritmus s blokmi: {$a->blocks} vo funkciách: {$a->functions}';
$string['rule_aihints'] = 'Po chybe alebo neúspešnom teste môžete požiadať AI o radu; riešenie neprezradí.';
$string['rule_ignorecase'] = 'Veľké a malé písmená sú rovnaké.';
$string['rule_ignorespaces'] = 'Medzery navyše sa nepočítajú.';
$string['rule_maxblocks'] = 'Najviac {$a} blokov.';
$string['rule_maxgrowth'] = 'Kroky musia rásť najviac ako {$a}.';
$string['rule_numbers'] = 'Testy porovnávajú len čísla, ktoré váš algoritmus vypíše, v poradí.';
$string['rule_numbersafter'] = 'Testy porovnávajú len čísla, ktoré váš algoritmus vypíše po poslednom vstupe, v poradí; text okolo nich môže byť ľubovoľný.';
$string['rule_stepfactor'] = 'V každom teste najviac {$a}-krát toľko krokov ako riešenie učiteľa.';
$string['rule_strictinit'] = 'Každá premenná, prvok poľa a položka musí dostať hodnotu pred použitím.';
$string['rule_structures'] = 'Algoritmus musí použiť: {$a}.';
$string['rule_text'] = 'Testy porovnávajú všetko, čo váš algoritmus vypíše.';
$string['rule_textafter'] = 'Testy porovnávajú to, čo váš algoritmus vypíše po poslednom vstupe.';
$string['rule_tolerance'] = 'Čísla sa môžu líšiť o {$a}.';
$string['showtests'] = 'Testy v pokuse';
$string['showtests_desc'] = 'Žiaci môžu počas práce spúšťať testy, ktoré nie sú skryté';
$string['solution'] = 'Riešenie';
$string['solutionandtests'] = 'Riešenie a testy';
$string['solutionblocks'] = 'Riešenie má {$a} blokov, viac ako tento limit.';
$string['solutionfails'] = 'Riešenie zlyháva v teste {$a->n}: {$a->error}';
$string['solutiongrowth'] = 'Kroky riešenia rastú ako {$a}, rýchlejšie ako tento limit.';
$string['solutionnogrowth'] = 'Rast riešenia nemožno zmerať: potrebuje veľkosť n (priradenie ako n = 10, alebo prvý vstup) a musí prebehnúť pre n = 10, 20 a 50.';
$string['stepfactor'] = 'Kroky v porovnaní s riešením';
$string['stepfactor_help'] = 'Odpoveď smie v každom teste urobiť najviac toľkokrát viac krokov ako riešenie učiteľa (0: bez obmedzenia). S hodnotou 1.5 smie odpoveď potrebovať o polovicu viac krokov ako riešenie. Krok je jeden vykonaný blok, ako v počítadle krokov editora.';
$string['stepfactorrange'] = 'Použite 0 pre žiadne obmedzenie, alebo číslo od 1.';
$string['strictinit'] = 'Prísna inicializácia';
$string['strictinit_desc'] = 'Premenná musí dostať hodnotu pred použitím';
$string['strictinit_help'] = 'Ako v C, C++ a Jave: čítanie premennej, prvku poľa alebo položky skôr, ako má hodnotu, zastaví algoritmus chybou (pri spusteniach žiaka aj pri hodnotení) a generovaný kód v C, C++, Jave a C# deklaruje premenné bez počiatočnej hodnoty. Bez tejto možnosti deklarovaná premenná začína od 0, prázdneho textu alebo false.';
$string['structure_array'] = 'pole';
$string['structure_dowhile'] = 'Cyklus Rob';
$string['structure_for'] = 'Cyklus Pre';
$string['structure_if'] = 'Ak';
$string['structure_matrix'] = 'matica';
$string['structure_record'] = 'záznam';
$string['structure_while'] = 'Cyklus Kým';
$string['structures'] = 'Požadované štruktúry';
$string['structures_help'] = 'Ak odpoveď nepoužije každú tu začiarknutú štruktúru, nedostane žiadne body, aj keď prejde testami.';
$string['studenteditor'] = 'Editor pre žiakov';
$string['template'] = 'Počiatočná šablóna';
$string['test'] = 'Test';
$string['testerror'] = 'Test {$a}: zastavený chybou';
$string['testfailed'] = 'Test {$a}: iný výstup';
$string['testpassed'] = 'Test {$a}: prešiel';
$string['tests'] = 'Testy';
$string['tests_help'] = 'Pridajte testy a zadajte ich vstupy, jednu hodnotu na riadok ("" pre prázdnu hodnotu). Test môže aj zavolať jednu z funkcií algoritmu: zvoľte funkciu a zadajte jej argumenty, napríklad 2, 3; porovnáva sa vrátená hodnota. Očakávané výstupy sa vypočítajú z vášho riešenia pri uložení otázky. Každý test má váhu (1, ak ju nezmeníte): test s váhou 2 sa počíta dvakrát. Skryté testy sa hodnotia, ale žiaci nevidia ich vstupy a výstupy.';
$string['testssummary'] = 'Prejdené testy: {$a->passed} z {$a->total}';
$string['tolerance'] = 'Tolerancia pre čísla';
$string['tolerance_help'] = 'Čísla vo výstupe sa môžu od očakávaných líšiť najviac o toľko, napríklad 0.01. Zvyšok riadku musí byť rovnaký. 0 porovnáva čísla presne.';
$string['tolerancenegative'] = 'Tolerancia nemôže byť záporná.';
$string['toolarge'] = 'Algoritmus je príliš veľký: môže mať najviac {$a} blokov.';
$string['usetemplate'] = 'Žiaci začínajú zo samostatnej šablóny namiesto z prázdneho diagramu';
$string['weight'] = 'Váha';
