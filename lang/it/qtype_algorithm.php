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
 * Strings for component 'qtype_algorithm', language 'it' (Italian).
 *
 * @package    qtype_algorithm
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['afterinput'] = 'Solo l\'output dopo l\'ultimo input';
$string['aihints'] = 'Suggerimenti dell\'IA';
$string['aihints_desc'] = 'Gli studenti possono chiedere all\'IA del sito suggerimenti su errori e test falliti';
$string['aihints_help'] = 'Con i suggerimenti dell\'IA attivi nelle impostazioni del plugin Editor di algoritmi e un fornitore di IA sul sito, gli studenti hanno nel tentativo i pulsanti Spiega con l\'IA (dopo un errore) e Suggerimento dell\'IA (accanto a un test fallito). L\'IA riceve l\'algoritmo dello studente come pseudocodice, l\'errore o il test visibile e il testo della domanda, e ha l\'istruzione di non dare mai la soluzione. Lasciarlo disattivato negli esami.';
$string['answerlegend'] = 'Il tuo algoritmo';
$string['cachedef_results'] = 'Risultati dei test delle risposte Algoritmo';
$string['compare'] = 'Cosa viene confrontato';
$string['copyfromsolution'] = 'Copia dalla soluzione';
$string['correctsolution'] = 'La soluzione del docente:';
$string['distractors'] = 'Blocchi errati aggiuntivi';
$string['distractors_help'] = 'Blocchi ricavati da blocchi della soluzione con un piccolo errore (< invece di <=, - 1 invece di + 1, or invece di and, un numero più grande di uno). Gli studenti devono escluderli.';
$string['efficiency'] = 'Efficienza';
$string['efficiency_blocks'] = 'L\'algoritmo ha {$a->blocks} blocchi; ne sono consentiti al massimo {$a->max}.';
$string['efficiency_growth'] = 'I passi dell\'algoritmo crescono come {$a->growth}; è consentito al massimo {$a->max}.';
$string['efficiency_growthunknown'] = 'Non è stato possibile misurare la crescita dell\'algoritmo: serve una dimensione n (un\'assegnazione come n = 10, o il primo input) e deve essere eseguito per n = 10, 20 e 50.';
$string['efficiency_steps'] = 'Test {$a->n}: l\'algoritmo ha impiegato {$a->steps} passi; ne sono consentiti al massimo {$a->max}.';
$string['efficiencypenalty'] = 'Penalità per una risposta non abbastanza efficiente (%)';
$string['efficiencypenalty_help'] = 'Quando la risposta supera i test ma viola una condizione di efficienza (passi, crescita o blocchi), questa percentuale viene tolta dal suo voto. 100 non dà punti a una risposta del genere, 0 mostra solo il messaggio.';
$string['efficiencypenaltyapplied'] = 'Per questo viene tolto il {$a} % dal voto.';
$string['efficiencypenaltyrange'] = 'La penalità è una percentuale da 0 a 100.';
$string['emptytemplate'] = 'Vuoto';
$string['expected'] = 'Atteso';
$string['failed'] = 'Fallito';
$string['gaps'] = 'Completa gli spazi';
$string['gaps_help'] = 'Se maggiore di 0, gli studenti non disegnano l’algoritmo: ricevono la soluzione con questo numero di espressioni e condizioni svuotate (scelte a caso all’inizio del tentativo) e scrivono solo le parti mancanti. I blocchi non si possono aggiungere, spostare o eliminare. La risposta è valutata con i test. Non usato in un problema di Parsons.';
$string['gapsintro'] = 'Completa gli spazi: scrivi le espressioni mancanti nei blocchi segnati con uno spazio (___). I blocchi restano dove sono.';
$string['got'] = 'Il tuo output';
$string['grademethod'] = 'Voto';
$string['grademethod_all'] = 'Punteggio pieno solo se tutti i test sono superati';
$string['grademethod_proportional'] = 'Quota dei test superati, secondo il loro peso';
$string['gradingnote'] = 'Con i test, la risposta viene valutata automaticamente: l\'algoritmo viene eseguito con gli input di ogni test e il suo output viene confrontato con l\'output della tua soluzione. Senza test, valuti la risposta manualmente.';
$string['growth_o1'] = '1 (costante)';
$string['growth_ologn'] = 'log n';
$string['growth_on'] = 'n (lineare)';
$string['growth_on2'] = 'n² (quadratica)';
$string['growth_on3'] = 'n³ (cubica)';
$string['growth_onlogn'] = 'n log n';
$string['hiddentest'] = 'Test nascosto';
$string['hidetools'] = 'Nascondi il codice generato e l\'importazione ed esportazione dei file';
$string['hidetools_help'] = 'Gli studenti non vedono il pannello del codice, l\'importazione ed esportazione .fprg né i pulsanti delle immagini nell\'editor del tentativo. Questo scoraggia la copia del codice dal diagramma (o di un diagramma da un file); non blocca nulla. La revisione dopo il tentativo mostra il codice come al solito.';
$string['ignorecase'] = 'Maiuscole e minuscole sono uguali';
$string['ignorespaces'] = 'Gli spazi in più non contano';
$string['inputs'] = 'Input';
$string['maxblocks'] = 'Massimo di blocchi';
$string['maxblocks_help'] = 'La risposta può avere al massimo questo numero di blocchi in tutte le sue funzioni (0: nessun limite). Una soluzione breve è spesso più chiara.';
$string['maxblocksnegative'] = 'Il numero di blocchi non può essere negativo.';
$string['maxgrowth'] = 'I passi possono crescere al massimo come';
$string['maxgrowth_help'] = 'La risposta viene eseguita per n = 10, 20, 50, 100, 200 e 500, i suoi passi vengono contati, e la crescita che li descrive meglio non deve essere più veloce di quella scelta qui (Complessità nell\'editor misura allo stesso modo). La dimensione n è un\'assegnazione di un numero intero come n = 10 nella funzione principale, altrimenti il primo valore che l\'algoritmo legge; gli altri valori letti sono numeri interi casuali.';
$string['maxgrowth_none'] = 'Nessun limite';
$string['missingstructures'] = 'L\'algoritmo deve usare: {$a}. La risposta non ottiene punti.';
$string['noalgorithm'] = 'Non è stato inviato alcun algoritmo.';
$string['noinput'] = 'L\'algoritmo chiede più input di quanti il test ne fornisca.';
$string['nosolution'] = 'Disegna la soluzione: gli output attesi dei test vengono calcolati da essa.';
$string['numbers'] = 'Solo i numeri (il testo intorno può essere qualsiasi)';
$string['numbers_help'] = 'Vengono confrontati solo i numeri dell\'output, in ordine, quindi gli studenti possono scrivere qualsiasi testo intorno. Con «Solo l\'output dopo l\'ultimo input», anche i messaggi come «Inserisci un numero» non contano.';
$string['ordercheck'] = 'Controlla l’ordine';
$string['ordercheck_desc'] = 'Gli studenti possono controllare l’ordine dei loro blocchi';
$string['ordercheck_help'] = 'Gli studenti hanno un pulsante Controlla l’ordine: segna i blocchi che non sono al loro posto (nel ciclo o ramo sbagliato, nell’ordine sbagliato o blocchi errati in più) senza eseguire l’algoritmo. La soluzione non viene mostrata. Il controllo non costa nulla, quindi usalo per esercitarsi.';
$string['parsons'] = 'Problema di Parsons';
$string['parsons_desc'] = 'Gli studenti ricevono i blocchi della soluzione in ordine casuale e li sistemano';
$string['parsons_help'] = 'Gli studenti non disegnano l\'algoritmo: ricevono ogni blocco della soluzione, in ordine casuale, con cicli e rami vuoti, e spostano i blocchi al loro posto. Non possono aggiungere blocchi né cambiarne il testo. La risposta viene valutata con i test, come ogni altra. Il modello iniziale non viene usato.';
$string['parsonsintro'] = 'Sistema i blocchi dati: sposta ogni blocco al suo posto (anche dentro cicli e rami) ed elimina i blocchi che non c\'entrano.';
$string['passed'] = 'Superato';
$string['pleasedrawalgorithm'] = 'Disegna un algoritmo: aggiungi almeno un blocco.';
$string['pluginname'] = 'Algoritmo';
$string['pluginname_help'] = 'Lo studente disegna un algoritmo come diagramma di flusso nella domanda e può eseguirlo. Con i test, la risposta viene valutata automaticamente; senza test, la valuta il docente.';
$string['pluginnameadding'] = 'Aggiunta di una domanda Algoritmo';
$string['pluginnameediting'] = 'Modifica di una domanda Algoritmo';
$string['pluginnamesummary'] = 'Lo studente disegna un algoritmo come diagramma di flusso e può eseguirlo. Valutato automaticamente con test calcolati dalla soluzione del docente, o manualmente.';
$string['privacy:metadata'] = 'Il tipo di domanda Algoritmo non memorizza dati personali. Le risposte sono memorizzate dal motore delle domande di Moodle. Il browser conserva alcune impostazioni di visualizzazione (codice e variabili mostrati o nascosti) nella sua memoria locale.';
$string['responsesummary'] = 'Algoritmo con {$a->blocks} blocco/i in {$a->functions} funzione/i';
$string['rule_aihints'] = 'Puoi chiedere un suggerimento all\'IA dopo un errore o un test fallito; non dà la soluzione.';
$string['rule_ignorecase'] = 'Maiuscole e minuscole sono uguali.';
$string['rule_ignorespaces'] = 'Gli spazi in più non contano.';
$string['rule_maxblocks'] = 'Al massimo {$a} blocchi.';
$string['rule_maxgrowth'] = 'I passi devono crescere al massimo come {$a}.';
$string['rule_numbers'] = 'I test confrontano solo i numeri che il tuo algoritmo scrive, in ordine.';
$string['rule_numbersafter'] = 'I test confrontano solo i numeri che il tuo algoritmo scrive dopo l\'ultimo input, in ordine; il testo intorno può essere qualsiasi.';
$string['rule_stepfactor'] = 'In ogni test al massimo {$a} volte i passi della soluzione del docente.';
$string['rule_structures'] = 'L\'algoritmo deve usare: {$a}.';
$string['rule_text'] = 'I test confrontano tutto ciò che il tuo algoritmo scrive.';
$string['rule_textafter'] = 'I test confrontano ciò che il tuo algoritmo scrive dopo l\'ultimo input.';
$string['rule_tolerance'] = 'I numeri possono differire di {$a}.';
$string['showtests'] = 'Test nel tentativo';
$string['showtests_desc'] = 'Gli studenti possono eseguire i test non nascosti mentre lavorano';
$string['solution'] = 'Soluzione';
$string['solutionandtests'] = 'Soluzione e test';
$string['solutionblocks'] = 'La soluzione ha {$a} blocchi, più di questo limite.';
$string['solutionfails'] = 'La soluzione fallisce nel test {$a->n}: {$a->error}';
$string['solutiongrowth'] = 'I passi della soluzione crescono come {$a}, più velocemente di questo limite.';
$string['solutionnogrowth'] = 'Non è possibile misurare la crescita della soluzione: serve una dimensione n (un\'assegnazione come n = 10, o il primo input) e deve essere eseguita per n = 10, 20 e 50.';
$string['stepfactor'] = 'Passi rispetto alla soluzione';
$string['stepfactor_help'] = 'In ogni test la risposta può impiegare al massimo questo numero di volte i passi della soluzione del docente (0: nessun limite). Con 1.5 una risposta può impiegare la metà dei passi in più della soluzione. Un passo è un blocco eseguito, come nel contapassi dell\'editor.';
$string['stepfactorrange'] = 'Usa 0 per nessun limite, o un numero da 1 in su.';
$string['structure_array'] = 'array';
$string['structure_dowhile'] = 'Ciclo Esegui';
$string['structure_for'] = 'Ciclo Per';
$string['structure_if'] = 'Se';
$string['structure_matrix'] = 'matrice';
$string['structure_record'] = 'record';
$string['structure_while'] = 'Ciclo Mentre';
$string['structures'] = 'Strutture richieste';
$string['structures_help'] = 'Se la risposta non usa ogni struttura spuntata qui, non ottiene punti, anche se supera i test.';
$string['studenteditor'] = 'Editor dello studente';
$string['template'] = 'Modello iniziale';
$string['test'] = 'Test';
$string['testerror'] = 'Test {$a}: interrotto da un errore';
$string['testfailed'] = 'Test {$a}: output diverso';
$string['testpassed'] = 'Test {$a}: superato';
$string['tests'] = 'Test';
$string['tests_help'] = 'Aggiungi i test e scrivi i loro input, un valore per riga ("" per un valore vuoto). Un test può anche chiamare una delle funzioni dell\'algoritmo: scegli la funzione e scrivi i suoi argomenti, per esempio 2, 3; viene confrontato il valore restituito. Gli output attesi vengono calcolati dalla tua soluzione quando la domanda viene salvata. Ogni test ha un peso (1 se non lo cambi): un test con peso 2 conta doppio. I test nascosti vengono valutati, ma gli studenti non vedono i loro input e output.';
$string['testssummary'] = 'Test superati: {$a->passed} su {$a->total}';
$string['tolerance'] = 'Tolleranza per i numeri';
$string['tolerance_help'] = 'I numeri dell\'output possono differire da quelli attesi al massimo di questa quantità, per esempio 0.01. Il resto della riga deve essere uguale. 0 confronta i numeri esattamente.';
$string['tolerancenegative'] = 'La tolleranza non può essere negativa.';
$string['toolarge'] = 'L\'algoritmo è troppo grande: può avere al massimo {$a} blocchi.';
$string['usetemplate'] = 'Gli studenti partono da un modello separato invece che da un diagramma vuoto';
$string['weight'] = 'Peso';
