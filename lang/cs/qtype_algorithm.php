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
 * Strings for component 'qtype_algorithm', language 'cs' (Czech).
 *
 * @package    qtype_algorithm
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['afterinput'] = 'Jen výstup po posledním vstupu';
$string['aihints'] = 'Rady AI';
$string['aihints_desc'] = 'Studenti mohou požádat AI stránek o rady k chybám a neúspěšným testům';
$string['aihints_help'] = 'Když jsou rady AI zapnuté v nastavení pluginu Editor algoritmů a stránky mají poskytovatele AI, studenti mají v pokusu tlačítka Vysvětlit s AI (po chybě) a Rada od AI (vedle neúspěšného testu). AI dostane studentův algoritmus jako pseudokód, chybu nebo viditelný test a text úlohy a má pokyn nikdy neprozradit řešení. Při zkouškách nechte vypnuté.';
$string['answerlegend'] = 'Váš algoritmus';
$string['cachedef_results'] = 'Výsledky testů odpovědí typu Algoritmus';
$string['compare'] = 'Co se porovnává';
$string['copyfromsolution'] = 'Kopírovat z řešení';
$string['correctsolution'] = 'Řešení učitele:';
$string['distractors'] = 'Další chybné bloky';
$string['distractors_help'] = 'Bloky vytvořené z bloků řešení s malou chybou (< místo <=, - 1 místo + 1, or místo and, číslo větší o jedna). Studenti je musí vynechat.';
$string['efficiency'] = 'Efektivita';
$string['efficiency_blocks'] = 'Algoritmus má {$a->blocks} bloků; povoleno je nejvýše {$a->max}.';
$string['efficiency_growth'] = 'Kroky algoritmu rostou jako {$a->growth}; povoleno je nejvýše {$a->max}.';
$string['efficiency_growthunknown'] = 'Růst algoritmu se nepodařilo změřit: potřebuje velikost n (přiřazení jako n = 10, nebo první vstup) a musí proběhnout pro n = 10, 20 a 50.';
$string['efficiency_steps'] = 'Test {$a->n}: algoritmus udělal {$a->steps} kroků; povoleno je nejvýše {$a->max}.';
$string['efficiencypenalty'] = 'Srážka za odpověď, která není dost efektivní (%)';
$string['efficiencypenalty_help'] = 'Když odpověď projde testy, ale poruší podmínku efektivity (kroky, růst nebo bloky), odečte se toto procento z jejího hodnocení. 100 nedá takové odpovědi žádné body, 0 jen zobrazí zprávu.';
$string['efficiencypenaltyapplied'] = 'Proto se z hodnocení odečítá {$a} %.';
$string['efficiencypenaltyrange'] = 'Srážka je procento od 0 do 100.';
$string['emptytemplate'] = 'Prázdná';
$string['expected'] = 'Očekáváno';
$string['failed'] = 'Neprošel';
$string['gaps'] = 'Doplnit mezery';
$string['gaps_help'] = 'Je-li víc než 0, žáci algoritmus nekreslí: dostanou řešení s tolika vyprázdněnými výrazy a podmínkami (vybranými náhodně na začátku pokusu) a píší jen chybějící části. Bloky nelze přidávat, přesouvat ani mazat. Odpověď se hodnotí testy. Nepoužívá se v Parsonsově úloze.';
$string['gapsintro'] = 'Doplň mezery: napiš chybějící výrazy do bloků označených mezerou (___). Bloky zůstávají, kde jsou.';
$string['got'] = 'Váš výstup';
$string['grademethod'] = 'Hodnocení';
$string['grademethod_all'] = 'Plný počet bodů jen tehdy, když projdou všechny testy';
$string['grademethod_proportional'] = 'Podíl prošlých testů podle jejich váhy';
$string['gradingnote'] = 'S testy se odpověď hodnotí automaticky: algoritmus proběhne se vstupy každého testu a jeho výstup se porovná s výstupem vašeho řešení. Bez testů hodnotíte odpověď ručně.';
$string['growth_o1'] = '1 (konstantní)';
$string['growth_ologn'] = 'log n';
$string['growth_on'] = 'n (lineární)';
$string['growth_on2'] = 'n² (kvadratický)';
$string['growth_on3'] = 'n³ (kubický)';
$string['growth_onlogn'] = 'n log n';
$string['hiddentest'] = 'Skrytý test';
$string['hidetools'] = 'Skrýt generovaný kód a import a export souborů';
$string['hidetools_help'] = 'Studenti v editoru pokusu nevidí panel kódu, import a export .fprg ani tlačítka obrázků. To odrazuje od opisování kódu z diagramu (nebo diagramu ze souboru); nic to nezamyká. Prohlídka po pokusu ukazuje kód jako obvykle.';
$string['ignorecase'] = 'Velká a malá písmena jsou stejná';
$string['ignorespaces'] = 'Mezery navíc se nepočítají';
$string['inputs'] = 'Vstup';
$string['maxblocks'] = 'Nejvíce bloků';
$string['maxblocks_help'] = 'Odpověď může mít ve všech svých funkcích nejvýše tolik bloků (0: bez omezení). Krátké řešení bývá přehlednější.';
$string['maxblocksnegative'] = 'Počet bloků nemůže být záporný.';
$string['maxgrowth'] = 'Kroky smějí růst nejvýše jako';
$string['maxgrowth_help'] = 'Odpověď proběhne pro n = 10, 20, 50, 100, 200 a 500, její kroky se spočítají a růst, který jim nejlépe odpovídá, nesmí být rychlejší než zde zvolený (Složitost v editoru měří stejně). Velikost n je přiřazení celého čísla jako n = 10 v hlavní funkci, jinak první hodnota, kterou algoritmus načte; ostatní načtené hodnoty jsou náhodná celá čísla.';
$string['maxgrowth_none'] = 'Bez omezení';
$string['missingstructures'] = 'Algoritmus musí použít: {$a}. Odpověď nedostane žádné body.';
$string['noalgorithm'] = 'Nebyl odeslán žádný algoritmus.';
$string['noinput'] = 'Algoritmus žádá více vstupů, než test poskytuje.';
$string['nosolution'] = 'Nakreslete řešení: očekávané výstupy testů se počítají z něj.';
$string['numbers'] = 'Jen čísla (text kolem nich může být libovolný)';
$string['numbers_help'] = 'Porovnávají se jen čísla ve výstupu, v pořadí, takže studenti kolem nich mohou psát libovolný text. S volbou „Jen výstup po posledním vstupu“ se nepočítají ani výzvy jako „Zadej číslo“.';
$string['ordercheck'] = 'Kontrola pořadí';
$string['ordercheck_desc'] = 'Žáci mohou zkontrolovat pořadí svých bloků';
$string['ordercheck_help'] = 'Žáci dostanou tlačítko Zkontrolovat pořadí: označí bloky, které nejsou na svém místě (ve špatném cyklu nebo větvi, ve špatném pořadí nebo nadbytečné chybné bloky), bez spuštění algoritmu. Řešení se nezobrazí. Kontrola nic nestojí, proto ji používejte k procvičování.';
$string['parsons'] = 'Parsonsova úloha';
$string['parsons_desc'] = 'Studenti dostanou bloky řešení v náhodném pořadí a seřadí je';
$string['parsons_help'] = 'Studenti algoritmus nekreslí: dostanou všechny bloky řešení v náhodném pořadí, s prázdnými cykly a větvemi, a přesunou bloky na jejich místa. Nemohou přidávat bloky ani měnit jejich text. Odpověď se hodnotí testy jako každá jiná. Počáteční šablona se nepoužívá.';
$string['parsonsintro'] = 'Seřaďte dané bloky: přesuňte každý blok na jeho místo (i do cyklů a větví) a smažte bloky, které tam nepatří.';
$string['passed'] = 'Prošel';
$string['pleasedrawalgorithm'] = 'Nakreslete algoritmus: přidejte alespoň jeden blok.';
$string['pluginname'] = 'Algoritmus';
$string['pluginname_help'] = 'Student v úloze nakreslí algoritmus jako vývojový diagram a může ho spustit. S testy se odpověď hodnotí automaticky; bez testů ji hodnotí učitel.';
$string['pluginnameadding'] = 'Přidání úlohy Algoritmus';
$string['pluginnameediting'] = 'Úprava úlohy Algoritmus';
$string['pluginnamesummary'] = 'Student nakreslí algoritmus jako vývojový diagram a může ho spustit. Hodnotí se automaticky testy vypočtenými z řešení učitele, nebo ručně.';
$string['privacy:metadata'] = 'Typ úlohy Algoritmus neukládá žádné osobní údaje. Odpovědi ukládá jádro úloh Moodle. Prohlížeč uchovává ve svém místním úložišti několik nastavení zobrazení (zda jsou kód a proměnné zobrazené nebo skryté).';
$string['responsesummary'] = 'Algoritmus s bloky: {$a->blocks} ve funkcích: {$a->functions}';
$string['rule_aihints'] = 'Po chybě nebo neúspěšném testu můžete požádat AI o radu; řešení neprozradí.';
$string['rule_ignorecase'] = 'Velká a malá písmena jsou stejná.';
$string['rule_ignorespaces'] = 'Mezery navíc se nepočítají.';
$string['rule_maxblocks'] = 'Nejvýše {$a} bloků.';
$string['rule_maxgrowth'] = 'Kroky musí růst nejvýše jako {$a}.';
$string['rule_numbers'] = 'Testy porovnávají jen čísla, která váš algoritmus vypíše, v pořadí.';
$string['rule_numbersafter'] = 'Testy porovnávají jen čísla, která váš algoritmus vypíše po posledním vstupu, v pořadí; text kolem nich může být libovolný.';
$string['rule_stepfactor'] = 'V každém testu nejvýše {$a}krát tolik kroků jako řešení učitele.';
$string['rule_strictinit'] = 'Každá proměnná, prvek pole a položka musí dostat hodnotu před použitím.';
$string['rule_structures'] = 'Algoritmus musí použít: {$a}.';
$string['rule_text'] = 'Testy porovnávají vše, co váš algoritmus vypíše.';
$string['rule_textafter'] = 'Testy porovnávají to, co váš algoritmus vypíše po posledním vstupu.';
$string['rule_tolerance'] = 'Čísla se mohou lišit o {$a}.';
$string['showtests'] = 'Testy v pokusu';
$string['showtests_desc'] = 'Studenti mohou během práce spouštět testy, které nejsou skryté';
$string['solution'] = 'Řešení';
$string['solutionandtests'] = 'Řešení a testy';
$string['solutionblocks'] = 'Řešení má {$a} bloků, více než tento limit.';
$string['solutionfails'] = 'Řešení selhává v testu {$a->n}: {$a->error}';
$string['solutiongrowth'] = 'Kroky řešení rostou jako {$a}, rychleji než tento limit.';
$string['solutionnogrowth'] = 'Růst řešení nelze změřit: potřebuje velikost n (přiřazení jako n = 10, nebo první vstup) a musí proběhnout pro n = 10, 20 a 50.';
$string['stepfactor'] = 'Kroky ve srovnání s řešením';
$string['stepfactor_help'] = 'Odpověď smí v každém testu udělat nejvýše tolikrát více kroků než řešení učitele (0: bez omezení). S hodnotou 1.5 smí odpověď potřebovat o polovinu více kroků než řešení. Krok je jeden provedený blok, jako v počítadle kroků editoru.';
$string['stepfactorrange'] = 'Použijte 0 pro žádné omezení, nebo číslo od 1.';
$string['strictinit'] = 'Přísná inicializace';
$string['strictinit_desc'] = 'Proměnná musí dostat hodnotu před použitím';
$string['strictinit_help'] = 'Jako v C, C++ a Javě: čtení proměnné, prvku pole nebo položky dřív, než má hodnotu, zastaví algoritmus chybou (při spuštěních žáka i při hodnocení) a generovaný kód v C, C++, Javě a C# deklaruje proměnné bez počáteční hodnoty. Bez této možnosti začíná deklarovaná proměnná od 0, prázdného textu nebo false.';
$string['structure_array'] = 'pole';
$string['structure_dowhile'] = 'Cyklus Dělej';
$string['structure_for'] = 'Cyklus Pro';
$string['structure_if'] = 'Pokud';
$string['structure_matrix'] = 'matice';
$string['structure_record'] = 'záznam';
$string['structure_while'] = 'Cyklus Dokud';
$string['structures'] = 'Požadované struktury';
$string['structures_help'] = 'Pokud odpověď nepoužije každou zde zaškrtnutou strukturu, nedostane žádné body, i když projde testy.';
$string['studenteditor'] = 'Editor pro studenty';
$string['template'] = 'Počáteční šablona';
$string['test'] = 'Test';
$string['testerror'] = 'Test {$a}: zastaven chybou';
$string['testfailed'] = 'Test {$a}: jiný výstup';
$string['testpassed'] = 'Test {$a}: prošel';
$string['tests'] = 'Testy';
$string['tests_help'] = 'Přidejte testy a zadejte jejich vstupy, jednu hodnotu na řádek ("" pro prázdnou hodnotu). Test může také zavolat jednu z funkcí algoritmu: zvolte funkci a zadejte její argumenty, například 2, 3; porovnává se vrácená hodnota. Očekávané výstupy se vypočítají z vašeho řešení při uložení úlohy. Každý test má váhu (1, pokud ji nezměníte): test s váhou 2 se počítá dvakrát. Skryté testy se hodnotí, ale studenti nevidí jejich vstupy a výstupy.';
$string['testssummary'] = 'Prošlé testy: {$a->passed} z {$a->total}';
$string['tolerance'] = 'Tolerance pro čísla';
$string['tolerance_help'] = 'Čísla ve výstupu se mohou od očekávaných lišit nejvýše o tolik, například 0.01. Zbytek řádku musí být stejný. 0 porovnává čísla přesně.';
$string['tolerancenegative'] = 'Tolerance nemůže být záporná.';
$string['toolarge'] = 'Algoritmus je příliš velký: může mít nejvýše {$a} bloků.';
$string['usetemplate'] = 'Studenti začínají ze samostatné šablony místo z prázdného diagramu';
$string['weight'] = 'Váha';
