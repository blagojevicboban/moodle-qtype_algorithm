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
 * Strings for component 'qtype_algorithm', language 'de' (German).
 *
 * @package    qtype_algorithm
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['afterinput'] = 'Nur die Ausgabe nach der letzten Eingabe';
$string['aihints'] = 'KI-Hinweise';
$string['aihints_desc'] = 'Lernende dürfen die KI der Website um Hinweise zu Fehlern und fehlgeschlagenen Tests bitten';
$string['aihints_help'] = 'Wenn KI-Hinweise in den Einstellungen des Algorithmus-Editor-Plugins aktiviert sind und die Website einen KI-Anbieter hat, erhalten Lernende im Versuch die Schaltflächen Mit KI erklären (nach einem Fehler) und Hinweis von der KI (neben einem fehlgeschlagenen Test). Die KI erhält den Algorithmus der/des Lernenden als Pseudocode, den Fehler oder den sichtbaren Test und den Fragetext und wird angewiesen, niemals die Lösung zu verraten. In Prüfungen ausgeschaltet lassen.';
$string['answerlegend'] = 'Ihr Algorithmus';
$string['cachedef_results'] = 'Testergebnisse von Algorithmus-Antworten';
$string['compare'] = 'Was verglichen wird';
$string['copyfromsolution'] = 'Aus der Lösung kopieren';
$string['correctsolution'] = 'Die Lösung der Lehrkraft:';
$string['distractors'] = 'Zusätzliche falsche Blöcke';
$string['distractors_help'] = 'Blöcke, die aus Blöcken der Lösung mit einem kleinen Fehler entstehen (< statt <=, - 1 statt + 1, or statt and, eine um eins größere Zahl). Lernende müssen sie weglassen.';
$string['efficiency'] = 'Effizienz';
$string['efficiency_blocks'] = 'Der Algorithmus hat {$a->blocks} Blöcke; höchstens {$a->max} sind erlaubt.';
$string['efficiency_growth'] = 'Die Schritte des Algorithmus wachsen wie {$a->growth}; höchstens {$a->max} ist erlaubt.';
$string['efficiency_growthunknown'] = 'Das Wachstum des Algorithmus konnte nicht gemessen werden: Er braucht eine Größe n (eine Zuweisung wie n = 10 oder die erste Eingabe) und muss für n = 10, 20 und 50 laufen.';
$string['efficiency_steps'] = 'Test {$a->n}: Der Algorithmus brauchte {$a->steps} Schritte; höchstens {$a->max} sind erlaubt.';
$string['efficiencypenalty'] = 'Abzug für eine nicht ausreichend effiziente Antwort (%)';
$string['efficiencypenalty_help'] = 'Wenn die Antwort die Tests besteht, aber eine Effizienzbedingung verletzt (Schritte, Wachstum oder Blöcke), wird dieser Prozentsatz von ihrer Bewertung abgezogen. 100 gibt einer solchen Antwort keine Punkte, 0 zeigt nur die Meldung.';
$string['efficiencypenaltyapplied'] = 'Deshalb werden {$a} % von der Bewertung abgezogen.';
$string['efficiencypenaltyrange'] = 'Der Abzug ist ein Prozentsatz von 0 bis 100.';
$string['emptytemplate'] = 'Leer';
$string['expected'] = 'Erwartet';
$string['failed'] = 'Nicht bestanden';
$string['got'] = 'Ihre Ausgabe';
$string['grademethod'] = 'Bewertung';
$string['grademethod_all'] = 'Volle Punktzahl nur, wenn alle Tests bestehen';
$string['grademethod_proportional'] = 'Anteil der bestandenen Tests, nach ihrem Gewicht';
$string['gradingnote'] = 'Mit Tests wird die Antwort automatisch bewertet: Der Algorithmus läuft mit den Eingaben jedes Tests, und seine Ausgabe wird mit der Ausgabe Ihrer Lösung verglichen. Ohne Tests bewerten Sie die Antwort manuell.';
$string['growth_o1'] = '1 (konstant)';
$string['growth_ologn'] = 'log n';
$string['growth_on'] = 'n (linear)';
$string['growth_on2'] = 'n² (quadratisch)';
$string['growth_on3'] = 'n³ (kubisch)';
$string['growth_onlogn'] = 'n log n';
$string['hiddentest'] = 'Verborgener Test';
$string['hidetools'] = 'Erzeugten Code sowie Dateiimport und -export ausblenden';
$string['hidetools_help'] = 'Lernende sehen im Editor des Versuchs weder den Codebereich noch den .fprg-Import und -Export oder die Bild-Schaltflächen. Das erschwert das Kopieren von Code aus dem Diagramm (oder eines Diagramms aus einer Datei); es sperrt nichts. Die Überprüfung nach dem Versuch zeigt den Code wie gewohnt.';
$string['ignorecase'] = 'Groß- und Kleinbuchstaben sind gleich';
$string['ignorespaces'] = 'Zusätzliche Leerzeichen zählen nicht';
$string['inputs'] = 'Eingabe';
$string['maxblocks'] = 'Höchstens Blöcke';
$string['maxblocks_help'] = 'Die Antwort darf in all ihren Funktionen zusammen höchstens so viele Blöcke haben (0: keine Grenze). Eine kurze Lösung ist oft eine klarere.';
$string['maxblocksnegative'] = 'Die Anzahl der Blöcke kann nicht negativ sein.';
$string['maxgrowth'] = 'Schritte dürfen höchstens wachsen wie';
$string['maxgrowth_help'] = 'Die Antwort läuft für n = 10, 20, 50, 100, 200 und 500, ihre Schritte werden gezählt, und das Wachstum, das am besten passt, darf nicht schneller sein als das hier gewählte (Komplexität im Editor misst genauso). Die Größe n ist eine Zuweisung einer ganzen Zahl wie n = 10 in der Hauptfunktion, sonst der erste Wert, den der Algorithmus liest; die anderen gelesenen Werte sind zufällige ganze Zahlen.';
$string['maxgrowth_none'] = 'Keine Grenze';
$string['missingstructures'] = 'Der Algorithmus muss Folgendes verwenden: {$a}. Die Antwort erhält keine Punkte.';
$string['noalgorithm'] = 'Es wurde kein Algorithmus abgegeben.';
$string['noinput'] = 'Der Algorithmus verlangt mehr Eingaben, als der Test liefert.';
$string['nosolution'] = 'Zeichnen Sie die Lösung: Die erwarteten Ausgaben der Tests werden aus ihr berechnet.';
$string['numbers'] = 'Nur die Zahlen (der Text um sie herum ist beliebig)';
$string['numbers_help'] = 'Nur die Zahlen in der Ausgabe werden der Reihe nach verglichen, Lernende können also beliebigen Text um sie herum schreiben. Mit „Nur die Ausgabe nach der letzten Eingabe“ zählen auch Aufforderungen wie „Gib eine Zahl ein“ nicht.';
$string['parsons'] = 'Parsons-Aufgabe';
$string['parsons_desc'] = 'Lernende erhalten die Blöcke der Lösung in zufälliger Reihenfolge und ordnen sie an';
$string['parsons_help'] = 'Lernende zeichnen den Algorithmus nicht: Sie erhalten jeden Block der Lösung in zufälliger Reihenfolge, mit leeren Schleifen und Verzweigungen, und verschieben die Blöcke an ihre Plätze. Sie können keine Blöcke hinzufügen und ihren Text nicht ändern. Die Antwort wird wie jede andere mit den Tests bewertet. Die Startvorlage wird nicht verwendet.';
$string['parsonsintro'] = 'Ordnen Sie die gegebenen Blöcke an: Verschieben Sie jeden Block an seinen Platz (auch in Schleifen und Verzweigungen) und löschen Sie die Blöcke, die nicht dazugehören.';
$string['passed'] = 'Bestanden';
$string['pleasedrawalgorithm'] = 'Bitte zeichnen Sie einen Algorithmus: Fügen Sie mindestens einen Block hinzu.';
$string['pluginname'] = 'Algorithmus';
$string['pluginname_help'] = 'Die/der Lernende zeichnet in der Frage einen Algorithmus als Flussdiagramm und kann ihn ausführen. Mit Tests wird die Antwort automatisch bewertet, ohne Tests bewertet sie die Lehrkraft.';
$string['pluginnameadding'] = 'Algorithmus-Frage hinzufügen';
$string['pluginnameediting'] = 'Algorithmus-Frage bearbeiten';
$string['pluginnamesummary'] = 'Die/der Lernende zeichnet einen Algorithmus als Flussdiagramm und kann ihn ausführen. Automatisch bewertet mit Tests, die aus der Lösung der Lehrkraft berechnet werden, oder manuell.';
$string['privacy:metadata'] = 'Der Fragetyp Algorithmus speichert keine personenbezogenen Daten. Antworten werden von der Moodle-Frage-Engine gespeichert. Der Browser speichert einige Anzeigeeinstellungen (Code und Variablen ein- oder ausgeblendet) in seinem lokalen Speicher.';
$string['responsesummary'] = 'Algorithmus mit {$a->blocks} Block/Blöcken in {$a->functions} Funktion(en)';
$string['rule_aihints'] = 'Nach einem Fehler oder einem fehlgeschlagenen Test dürfen Sie die KI um einen Hinweis bitten; sie verrät die Lösung nicht.';
$string['rule_ignorecase'] = 'Groß- und Kleinbuchstaben sind gleich.';
$string['rule_ignorespaces'] = 'Zusätzliche Leerzeichen zählen nicht.';
$string['rule_maxblocks'] = 'Höchstens {$a} Blöcke.';
$string['rule_maxgrowth'] = 'Die Schritte dürfen höchstens wachsen wie {$a}.';
$string['rule_numbers'] = 'Die Tests vergleichen nur die Zahlen, die Ihr Algorithmus ausgibt, der Reihe nach.';
$string['rule_numbersafter'] = 'Die Tests vergleichen nur die Zahlen, die Ihr Algorithmus nach der letzten Eingabe ausgibt, der Reihe nach; der Text um sie herum ist beliebig.';
$string['rule_stepfactor'] = 'In jedem Test höchstens {$a}-mal so viele Schritte wie die Lösung der Lehrkraft.';
$string['rule_structures'] = 'Der Algorithmus muss Folgendes verwenden: {$a}.';
$string['rule_text'] = 'Die Tests vergleichen alles, was Ihr Algorithmus ausgibt.';
$string['rule_textafter'] = 'Die Tests vergleichen, was Ihr Algorithmus nach der letzten Eingabe ausgibt.';
$string['rule_tolerance'] = 'Zahlen dürfen um {$a} abweichen.';
$string['showtests'] = 'Tests im Versuch';
$string['showtests_desc'] = 'Lernende können während der Arbeit die nicht verborgenen Tests ausführen';
$string['solution'] = 'Lösung';
$string['solutionandtests'] = 'Lösung und Tests';
$string['solutionblocks'] = 'Die Lösung hat {$a} Blöcke, mehr als diese Grenze.';
$string['solutionfails'] = 'Die Lösung scheitert an Test {$a->n}: {$a->error}';
$string['solutiongrowth'] = 'Die Schritte der Lösung wachsen wie {$a}, schneller als diese Grenze.';
$string['solutionnogrowth'] = 'Das Wachstum der Lösung kann nicht gemessen werden: Sie braucht eine Größe n (eine Zuweisung wie n = 10 oder die erste Eingabe) und muss für n = 10, 20 und 50 laufen.';
$string['stepfactor'] = 'Schritte im Vergleich zur Lösung';
$string['stepfactor_help'] = 'Die Antwort darf in jedem Test höchstens so viele Male die Schritte der Lösung der Lehrkraft brauchen (0: keine Grenze). Mit 1.5 darf eine Antwort halb so viele Schritte mehr brauchen als die Lösung. Ein Schritt ist ein ausgeführter Block, wie im Schrittzähler des Editors.';
$string['stepfactorrange'] = 'Verwenden Sie 0 für keine Grenze oder eine Zahl ab 1.';
$string['structure_array'] = 'Array';
$string['structure_dowhile'] = 'Do-Schleife';
$string['structure_for'] = 'For-Schleife';
$string['structure_if'] = 'If';
$string['structure_matrix'] = 'Matrix';
$string['structure_record'] = 'Record';
$string['structure_while'] = 'While-Schleife';
$string['structures'] = 'Erforderliche Strukturen';
$string['structures_help'] = 'Wenn die Antwort nicht jede hier angekreuzte Struktur verwendet, erhält sie keine Punkte, auch wenn die Tests bestehen.';
$string['studenteditor'] = 'Editor für Lernende';
$string['template'] = 'Startvorlage';
$string['test'] = 'Test';
$string['testerror'] = 'Test {$a}: mit einem Fehler beendet';
$string['testfailed'] = 'Test {$a}: andere Ausgabe';
$string['testpassed'] = 'Test {$a}: bestanden';
$string['tests'] = 'Tests';
$string['tests_help'] = 'Fügen Sie Tests hinzu und geben Sie ihre Eingaben ein, ein Wert pro Zeile ("" für einen leeren Wert). Ein Test kann auch eine der Funktionen des Algorithmus aufrufen: Wählen Sie die Funktion und geben Sie ihre Argumente ein, zum Beispiel 2, 3; der zurückgegebene Wert wird verglichen. Die erwarteten Ausgaben werden beim Speichern der Frage aus Ihrer Lösung berechnet. Jeder Test hat ein Gewicht (1, sofern Sie es nicht ändern): Ein Test mit Gewicht 2 zählt doppelt. Verborgene Tests werden bewertet, aber Lernende sehen ihre Ein- und Ausgaben nicht.';
$string['testssummary'] = 'Bestandene Tests: {$a->passed} von {$a->total}';
$string['tolerance'] = 'Toleranz für Zahlen';
$string['tolerance_help'] = 'Zahlen in der Ausgabe dürfen von den erwarteten höchstens um so viel abweichen, zum Beispiel 0.01. Der Rest der Zeile muss gleich sein. 0 vergleicht die Zahlen genau.';
$string['tolerancenegative'] = 'Die Toleranz kann nicht negativ sein.';
$string['toolarge'] = 'Der Algorithmus ist zu groß: Er darf höchstens {$a} Blöcke haben.';
$string['usetemplate'] = 'Lernende beginnen mit einer eigenen Vorlage statt mit einem leeren Diagramm';
$string['weight'] = 'Gewicht';
