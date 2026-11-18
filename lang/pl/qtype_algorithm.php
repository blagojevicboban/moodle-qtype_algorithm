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
 * Strings for component 'qtype_algorithm', language 'pl' (Polish).
 *
 * @package    qtype_algorithm
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['afterinput'] = 'Tylko wyjście po ostatnim wejściu';
$string['aihints'] = 'Podpowiedzi AI';
$string['aihints_desc'] = 'Uczniowie mogą prosić AI serwisu o podpowiedzi dotyczące błędów i niezaliczonych testów';
$string['aihints_help'] = 'Gdy podpowiedzi AI są włączone w ustawieniach wtyczki Edytor algorytmów, a serwis ma dostawcę AI, uczniowie mają w podejściu przyciski Wyjaśnij z AI (po błędzie) i Podpowiedź AI (obok niezaliczonego testu). AI otrzymuje algorytm ucznia jako pseudokod, błąd lub widoczny test oraz treść pytania i ma polecenie, by nigdy nie podawać rozwiązania. Na egzaminach pozostaw wyłączone.';
$string['answerlegend'] = 'Twój algorytm';
$string['cachedef_results'] = 'Wyniki testów odpowiedzi typu Algorytm';
$string['compare'] = 'Co jest porównywane';
$string['copyfromsolution'] = 'Kopiuj z rozwiązania';
$string['correctsolution'] = 'Rozwiązanie nauczyciela:';
$string['distractors'] = 'Dodatkowe błędne bloki';
$string['distractors_help'] = 'Bloki utworzone z bloków rozwiązania z drobnym błędem (< zamiast <=, - 1 zamiast + 1, or zamiast and, liczba większa o jeden). Uczniowie muszą je pominąć.';
$string['efficiency'] = 'Wydajność';
$string['efficiency_blocks'] = 'Algorytm ma {$a->blocks} bloków; dozwolonych jest najwyżej {$a->max}.';
$string['efficiency_growth'] = 'Kroki algorytmu rosną jak {$a->growth}; dozwolone jest najwyżej {$a->max}.';
$string['efficiency_growthunknown'] = 'Nie udało się zmierzyć wzrostu algorytmu: potrzebuje rozmiaru n (przypisania takiego jak n = 10 lub pierwszego wejścia) i musi działać dla n = 10, 20 i 50.';
$string['efficiency_steps'] = 'Test {$a->n}: algorytm wykonał {$a->steps} kroków; dozwolonych jest najwyżej {$a->max}.';
$string['efficiencypenalty'] = 'Kara za odpowiedź niewystarczająco wydajną (%)';
$string['efficiencypenalty_help'] = 'Gdy odpowiedź zalicza testy, ale łamie warunek wydajności (kroki, wzrost lub bloki), ten procent jest odejmowany od jej oceny. 100 nie daje takiej odpowiedzi punktów, 0 tylko pokazuje komunikat.';
$string['efficiencypenaltyapplied'] = 'Z tego powodu od oceny odejmuje się {$a} %.';
$string['efficiencypenaltyrange'] = 'Kara to procent od 0 do 100.';
$string['emptytemplate'] = 'Pusty';
$string['expected'] = 'Oczekiwane';
$string['failed'] = 'Niezaliczony';
$string['gaps'] = 'Uzupełnij luki';
$string['gaps_help'] = 'Gdy więcej niż 0, uczniowie nie rysują algorytmu: dostają rozwiązanie z tyloma wyczyszczonymi wyrażeniami i warunkami (wybranymi losowo na początku podejścia) i wpisują tylko brakujące części. Bloków nie można dodawać, przesuwać ani usuwać. Odpowiedź jest oceniana testami. Nie dotyczy problemu Parsonsa.';
$string['gapsintro'] = 'Uzupełnij luki: wpisz brakujące wyrażenia w blokach oznaczonych luką (___). Bloki zostają na swoich miejscach.';
$string['got'] = 'Twoje wyjście';
$string['grademethod'] = 'Ocena';
$string['grademethod_all'] = 'Pełna ocena tylko wtedy, gdy wszystkie testy są zaliczone';
$string['grademethod_proportional'] = 'Część zaliczonych testów według ich wagi';
$string['gradingnote'] = 'Z testami odpowiedź jest oceniana automatycznie: algorytm działa na wejściach każdego testu, a jego wyjście jest porównywane z wyjściem Twojego rozwiązania. Bez testów oceniasz odpowiedź ręcznie.';
$string['growth_o1'] = '1 (stały)';
$string['growth_ologn'] = 'log n';
$string['growth_on'] = 'n (liniowy)';
$string['growth_on2'] = 'n² (kwadratowy)';
$string['growth_on3'] = 'n³ (sześcienny)';
$string['growth_onlogn'] = 'n log n';
$string['hiddentest'] = 'Ukryty test';
$string['hidetools'] = 'Ukryj wygenerowany kod oraz import i eksport plików';
$string['hidetools_help'] = 'Uczniowie nie widzą panelu kodu, importu i eksportu .fprg ani przycisków obrazu w edytorze podejścia. To zniechęca do kopiowania kodu z diagramu (lub diagramu z pliku); niczego nie blokuje. Przegląd po podejściu pokazuje kod jak zwykle.';
$string['ignorecase'] = 'Wielkie i małe litery są takie same';
$string['ignorespaces'] = 'Dodatkowe spacje się nie liczą';
$string['inputs'] = 'Wejście';
$string['maxblocks'] = 'Najwięcej bloków';
$string['maxblocks_help'] = 'Odpowiedź może mieć we wszystkich swoich funkcjach najwyżej tyle bloków (0: bez limitu). Krótkie rozwiązanie jest często jaśniejsze.';
$string['maxblocksnegative'] = 'Liczba bloków nie może być ujemna.';
$string['maxgrowth'] = 'Kroki mogą rosnąć najwyżej jak';
$string['maxgrowth_help'] = 'Odpowiedź działa dla n = 10, 20, 50, 100, 200 i 500, jej kroki są liczone, a wzrost, który najlepiej do nich pasuje, nie może być szybszy niż wybrany tutaj (Złożoność w edytorze mierzy tak samo). Rozmiar n to przypisanie liczby całkowitej, takie jak n = 10 w funkcji głównej, a w przeciwnym razie pierwsza wartość, którą algorytm wczytuje; pozostałe wczytywane wartości to losowe liczby całkowite.';
$string['maxgrowth_none'] = 'Bez limitu';
$string['missingstructures'] = 'Algorytm musi używać: {$a}. Odpowiedź nie otrzymuje punktów.';
$string['noalgorithm'] = 'Nie przesłano żadnego algorytmu.';
$string['noinput'] = 'Algorytm prosi o więcej danych wejściowych, niż zapewnia test.';
$string['nosolution'] = 'Narysuj rozwiązanie: oczekiwane wyjścia testów są z niego obliczane.';
$string['numbers'] = 'Tylko liczby (tekst wokół nich może być dowolny)';
$string['numbers_help'] = 'Porównywane są tylko liczby na wyjściu, w kolejności, więc uczniowie mogą pisać wokół nich dowolny tekst. Przy opcji „Tylko wyjście po ostatnim wejściu” komunikaty takie jak „Podaj liczbę” również się nie liczą.';
$string['ordercheck'] = 'Sprawdź kolejność';
$string['ordercheck_desc'] = 'Uczniowie mogą sprawdzić kolejność swoich bloków';
$string['ordercheck_help'] = 'Uczniowie dostają przycisk Sprawdź kolejność: zaznacza bloki, które nie są na swoim miejscu (w złej pętli lub gałęzi, w złej kolejności lub zbędne błędne bloki), bez uruchamiania algorytmu. Rozwiązanie nie jest pokazywane. Sprawdzanie nic nie kosztuje, więc służy do ćwiczeń.';
$string['parsons'] = 'Zadanie Parsonsa';
$string['parsons_desc'] = 'Uczniowie otrzymują bloki rozwiązania w losowej kolejności i je układają';
$string['parsons_help'] = 'Uczniowie nie rysują algorytmu: otrzymują każdy blok rozwiązania w losowej kolejności, z pustymi pętlami i gałęziami, i przesuwają bloki na ich miejsca. Nie mogą dodawać bloków ani zmieniać ich tekstu. Odpowiedź jest oceniana testami, jak każda inna. Szablon początkowy nie jest używany.';
$string['parsonsintro'] = 'Ułóż podane bloki: przesuń każdy blok na jego miejsce (także do pętli i gałęzi) i usuń bloki, które nie pasują.';
$string['passed'] = 'Zaliczony';
$string['pleasedrawalgorithm'] = 'Narysuj algorytm: dodaj co najmniej jeden blok.';
$string['pluginname'] = 'Algorytm';
$string['pluginname_help'] = 'Uczeń rysuje w pytaniu algorytm w postaci schematu blokowego i może go uruchomić. Z testami odpowiedź jest oceniana automatycznie; bez testów ocenia ją nauczyciel.';
$string['pluginnameadding'] = 'Dodawanie pytania Algorytm';
$string['pluginnameediting'] = 'Edytowanie pytania Algorytm';
$string['pluginnamesummary'] = 'Uczeń rysuje algorytm w postaci schematu blokowego i może go uruchomić. Oceniane automatycznie testami obliczonymi z rozwiązania nauczyciela lub ręcznie.';
$string['privacy:metadata'] = 'Typ pytania Algorytm nie przechowuje danych osobowych. Odpowiedzi przechowuje silnik pytań Moodle. Przeglądarka przechowuje kilka ustawień wyświetlania (kod i zmienne pokazane lub ukryte) w swojej pamięci lokalnej.';
$string['responsesummary'] = 'Algorytm z {$a->blocks} blokami w {$a->functions} funkcjach';
$string['rule_aihints'] = 'Po błędzie lub niezaliczonym teście możesz poprosić AI o podpowiedź; nie poda ona rozwiązania.';
$string['rule_ignorecase'] = 'Wielkie i małe litery są takie same.';
$string['rule_ignorespaces'] = 'Dodatkowe spacje się nie liczą.';
$string['rule_maxblocks'] = 'Najwyżej {$a} bloków.';
$string['rule_maxgrowth'] = 'Kroki muszą rosnąć najwyżej jak {$a}.';
$string['rule_numbers'] = 'Testy porównują tylko liczby, które wypisuje Twój algorytm, w kolejności.';
$string['rule_numbersafter'] = 'Testy porównują tylko liczby, które Twój algorytm wypisuje po ostatnim wejściu, w kolejności; tekst wokół nich może być dowolny.';
$string['rule_stepfactor'] = 'W każdym teście najwyżej {$a} razy tyle kroków co rozwiązanie nauczyciela.';
$string['rule_structures'] = 'Algorytm musi używać: {$a}.';
$string['rule_text'] = 'Testy porównują wszystko, co wypisuje Twój algorytm.';
$string['rule_textafter'] = 'Testy porównują to, co Twój algorytm wypisuje po ostatnim wejściu.';
$string['rule_tolerance'] = 'Liczby mogą się różnić o {$a}.';
$string['showtests'] = 'Testy w podejściu';
$string['showtests_desc'] = 'Uczniowie mogą uruchamiać nieukryte testy podczas pracy';
$string['solution'] = 'Rozwiązanie';
$string['solutionandtests'] = 'Rozwiązanie i testy';
$string['solutionblocks'] = 'Rozwiązanie ma {$a} bloków, więcej niż ten limit.';
$string['solutionfails'] = 'Rozwiązanie nie przechodzi testu {$a->n}: {$a->error}';
$string['solutiongrowth'] = 'Kroki rozwiązania rosną jak {$a}, szybciej niż ten limit.';
$string['solutionnogrowth'] = 'Nie można zmierzyć wzrostu rozwiązania: potrzebuje rozmiaru n (przypisania takiego jak n = 10 lub pierwszego wejścia) i musi działać dla n = 10, 20 i 50.';
$string['stepfactor'] = 'Kroki w porównaniu z rozwiązaniem';
$string['stepfactor_help'] = 'W każdym teście odpowiedź może wykonać najwyżej tyle razy więcej kroków niż rozwiązanie nauczyciela (0: bez limitu). Przy 1.5 odpowiedź może potrzebować o połowę więcej kroków niż rozwiązanie. Krok to jeden wykonany blok, jak w liczniku kroków edytora.';
$string['stepfactorrange'] = 'Użyj 0 dla braku limitu lub liczby od 1.';
$string['structure_array'] = 'tablica';
$string['structure_dowhile'] = 'Pętla Wykonuj';
$string['structure_for'] = 'Pętla Dla';
$string['structure_if'] = 'Jeżeli';
$string['structure_matrix'] = 'macierz';
$string['structure_record'] = 'rekord';
$string['structure_while'] = 'Pętla Dopóki';
$string['structures'] = 'Wymagane struktury';
$string['structures_help'] = 'Jeśli odpowiedź nie używa każdej zaznaczonej tu struktury, nie otrzymuje punktów, nawet gdy testy są zaliczone.';
$string['studenteditor'] = 'Edytor ucznia';
$string['template'] = 'Szablon początkowy';
$string['test'] = 'Test';
$string['testerror'] = 'Test {$a}: zatrzymany przez błąd';
$string['testfailed'] = 'Test {$a}: inne wyjście';
$string['testpassed'] = 'Test {$a}: zaliczony';
$string['tests'] = 'Testy';
$string['tests_help'] = 'Dodaj testy i wpisz ich dane wejściowe, jedną wartość w wierszu ("" dla pustej wartości). Test może też wywołać jedną z funkcji algorytmu: wybierz funkcję i wpisz jej argumenty, na przykład 2, 3; porównywana jest zwrócona wartość. Oczekiwane wyjścia są obliczane z Twojego rozwiązania przy zapisywaniu pytania. Każdy test ma wagę (1, jeśli jej nie zmienisz): test o wadze 2 liczy się podwójnie. Ukryte testy są oceniane, ale uczniowie nie widzą ich wejść i wyjść.';
$string['testssummary'] = 'Zaliczone testy: {$a->passed} z {$a->total}';
$string['tolerance'] = 'Tolerancja dla liczb';
$string['tolerance_help'] = 'Liczby na wyjściu mogą różnić się od oczekiwanych najwyżej o tyle, na przykład 0.01. Reszta wiersza musi być taka sama. 0 porównuje liczby dokładnie.';
$string['tolerancenegative'] = 'Tolerancja nie może być ujemna.';
$string['toolarge'] = 'Algorytm jest za duży: może mieć najwyżej {$a} bloków.';
$string['usetemplate'] = 'Uczniowie zaczynają od osobnego szablonu zamiast od pustego diagramu';
$string['weight'] = 'Waga';
