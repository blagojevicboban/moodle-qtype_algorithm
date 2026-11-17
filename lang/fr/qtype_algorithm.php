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
 * Strings for component 'qtype_algorithm', language 'fr' (French).
 *
 * @package    qtype_algorithm
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['afterinput'] = 'Seulement la sortie après la dernière saisie';
$string['aihints'] = 'Indices de l\'IA';
$string['aihints_desc'] = 'Les élèves peuvent demander à l\'IA du site des indices sur les erreurs et les tests échoués';
$string['aihints_help'] = 'Avec les indices de l\'IA activés dans les réglages du plugin Éditeur d\'algorithmes et un fournisseur d\'IA sur le site, les élèves ont dans la tentative les boutons Expliquer avec l\'IA (après une erreur) et Indice de l\'IA (à côté d\'un test échoué). L\'IA reçoit l\'algorithme de l\'élève en pseudo-code, l\'erreur ou le test visible et le texte de la question, et a pour consigne de ne jamais donner la solution. À désactiver pendant les examens.';
$string['answerlegend'] = 'Votre algorithme';
$string['cachedef_results'] = 'Résultats des tests des réponses Algorithme';
$string['compare'] = 'Ce qui est comparé';
$string['copyfromsolution'] = 'Copier depuis la solution';
$string['correctsolution'] = 'La solution de l\'enseignant :';
$string['distractors'] = 'Blocs faux supplémentaires';
$string['distractors_help'] = 'Des blocs tirés de la solution avec une petite erreur (< au lieu de <=, - 1 au lieu de + 1, or au lieu de and, un nombre plus grand de un). Les élèves doivent les écarter.';
$string['efficiency'] = 'Efficacité';
$string['efficiency_blocks'] = 'L\'algorithme a {$a->blocks} blocs ; au plus {$a->max} sont autorisés.';
$string['efficiency_growth'] = 'Les pas de l\'algorithme croissent comme {$a->growth} ; au plus {$a->max} est autorisé.';
$string['efficiency_growthunknown'] = 'La croissance de l\'algorithme n\'a pas pu être mesurée : il lui faut une taille n (une affectation comme n = 10, ou la première saisie) et il doit s\'exécuter pour n = 10, 20 et 50.';
$string['efficiency_steps'] = 'Test {$a->n} : l\'algorithme a fait {$a->steps} pas ; au plus {$a->max} sont autorisés.';
$string['efficiencypenalty'] = 'Pénalité pour une réponse pas assez efficace (%)';
$string['efficiencypenalty_help'] = 'Quand la réponse réussit les tests mais ne respecte pas une condition d\'efficacité (pas, croissance ou blocs), ce pourcentage est retiré de sa note. 100 ne donne aucun point à une telle réponse, 0 affiche seulement le message.';
$string['efficiencypenaltyapplied'] = 'Pour cette raison, {$a} % sont retirés de la note.';
$string['efficiencypenaltyrange'] = 'La pénalité est un pourcentage de 0 à 100.';
$string['emptytemplate'] = 'Vide';
$string['expected'] = 'Attendu';
$string['failed'] = 'Échoué';
$string['got'] = 'Votre sortie';
$string['grademethod'] = 'Note';
$string['grademethod_all'] = 'Note maximale seulement si tous les tests réussissent';
$string['grademethod_proportional'] = 'Part des tests réussis, selon leur poids';
$string['gradingnote'] = 'Avec des tests, la réponse est notée automatiquement : l\'algorithme s\'exécute sur les entrées de chaque test et sa sortie est comparée à celle de votre solution. Sans tests, vous notez la réponse manuellement.';
$string['growth_o1'] = '1 (constante)';
$string['growth_ologn'] = 'log n';
$string['growth_on'] = 'n (linéaire)';
$string['growth_on2'] = 'n² (quadratique)';
$string['growth_on3'] = 'n³ (cubique)';
$string['growth_onlogn'] = 'n log n';
$string['hiddentest'] = 'Test caché';
$string['hidetools'] = 'Masquer le code généré ainsi que l\'import et l\'export de fichiers';
$string['hidetools_help'] = 'Les élèves ne voient pas le panneau du code, l\'import et l\'export .fprg ni les boutons d\'image dans l\'éditeur de la tentative. Cela décourage la copie de code depuis le diagramme (ou d\'un diagramme depuis un fichier) ; rien n\'est verrouillé. La relecture après la tentative montre le code comme d\'habitude.';
$string['ignorecase'] = 'Majuscules et minuscules sont identiques';
$string['ignorespaces'] = 'Les espaces en trop ne comptent pas';
$string['inputs'] = 'Entrée';
$string['maxblocks'] = 'Nombre maximal de blocs';
$string['maxblocks_help'] = 'La réponse peut avoir au plus ce nombre de blocs dans toutes ses fonctions (0 : pas de limite). Une solution courte est souvent plus claire.';
$string['maxblocksnegative'] = 'Le nombre de blocs ne peut pas être négatif.';
$string['maxgrowth'] = 'Les pas peuvent croître au plus comme';
$string['maxgrowth_help'] = 'La réponse s\'exécute pour n = 10, 20, 50, 100, 200 et 500, ses pas sont comptés, et la croissance qui leur correspond le mieux ne doit pas être plus rapide que celle choisie ici (Complexité dans l\'éditeur mesure de la même façon). La taille n est l\'affectation d\'un nombre entier comme n = 10 dans la fonction principale, sinon la première valeur que l\'algorithme lit ; les autres valeurs lues sont des nombres entiers aléatoires.';
$string['maxgrowth_none'] = 'Pas de limite';
$string['missingstructures'] = 'L\'algorithme doit utiliser : {$a}. La réponse n\'obtient aucun point.';
$string['noalgorithm'] = 'Aucun algorithme n\'a été soumis.';
$string['noinput'] = 'L\'algorithme demande plus d\'entrées que le test n\'en fournit.';
$string['nosolution'] = 'Dessinez la solution : les sorties attendues des tests en sont calculées.';
$string['numbers'] = 'Seulement les nombres (le texte autour peut être quelconque)';
$string['numbers_help'] = 'Seuls les nombres de la sortie sont comparés, dans l\'ordre, les élèves peuvent donc écrire n\'importe quel texte autour. Avec « Seulement la sortie après la dernière saisie », les invites comme « Entrez un nombre » ne comptent pas non plus.';
$string['parsons'] = 'Problème de Parsons';
$string['parsons_desc'] = 'Les élèves reçoivent les blocs de la solution dans un ordre aléatoire et les remettent en ordre';
$string['parsons_help'] = 'Les élèves ne dessinent pas l\'algorithme : ils reçoivent chaque bloc de la solution, dans un ordre aléatoire, avec les boucles et les branches vides, et déplacent les blocs à leur place. Ils ne peuvent ni ajouter de blocs ni changer leur texte. La réponse est notée avec les tests, comme toute autre. Le modèle de départ n\'est pas utilisé.';
$string['parsonsintro'] = 'Mettez en ordre les blocs donnés : déplacez chaque bloc à sa place (y compris dans les boucles et les branches) et supprimez les blocs qui n\'ont pas leur place.';
$string['passed'] = 'Réussi';
$string['pleasedrawalgorithm'] = 'Veuillez dessiner un algorithme : ajoutez au moins un bloc.';
$string['pluginname'] = 'Algorithme';
$string['pluginname_help'] = 'L\'élève dessine un algorithme sous forme d\'organigramme dans la question et peut l\'exécuter. Avec des tests, la réponse est notée automatiquement ; sans tests, l\'enseignant la note.';
$string['pluginnameadding'] = 'Ajout d\'une question Algorithme';
$string['pluginnameediting'] = 'Modification d\'une question Algorithme';
$string['pluginnamesummary'] = 'L\'élève dessine un algorithme sous forme d\'organigramme et peut l\'exécuter. Noté automatiquement avec des tests calculés à partir de la solution de l\'enseignant, ou manuellement.';
$string['privacy:metadata'] = 'Le type de question Algorithme ne stocke aucune donnée personnelle. Les réponses sont stockées par le moteur de questions de Moodle. Le navigateur garde quelques réglages d\'affichage (code et variables affichés ou masqués) dans son stockage local.';
$string['responsesummary'] = 'Algorithme avec {$a->blocks} bloc(s) dans {$a->functions} fonction(s)';
$string['rule_aihints'] = 'Vous pouvez demander un indice à l\'IA après une erreur ou un test échoué ; elle ne donne pas la solution.';
$string['rule_ignorecase'] = 'Majuscules et minuscules sont identiques.';
$string['rule_ignorespaces'] = 'Les espaces en trop ne comptent pas.';
$string['rule_maxblocks'] = 'Au plus {$a} blocs.';
$string['rule_maxgrowth'] = 'Les pas doivent croître au plus comme {$a}.';
$string['rule_numbers'] = 'Les tests comparent seulement les nombres que votre algorithme écrit, dans l\'ordre.';
$string['rule_numbersafter'] = 'Les tests comparent seulement les nombres que votre algorithme écrit après la dernière saisie, dans l\'ordre ; le texte autour peut être quelconque.';
$string['rule_stepfactor'] = 'Dans chaque test, au plus {$a} fois les pas de la solution de l\'enseignant.';
$string['rule_structures'] = 'L\'algorithme doit utiliser : {$a}.';
$string['rule_text'] = 'Les tests comparent tout ce que votre algorithme écrit.';
$string['rule_textafter'] = 'Les tests comparent ce que votre algorithme écrit après la dernière saisie.';
$string['rule_tolerance'] = 'Les nombres peuvent différer de {$a}.';
$string['showtests'] = 'Tests dans la tentative';
$string['showtests_desc'] = 'Les élèves peuvent exécuter les tests non cachés pendant qu\'ils travaillent';
$string['solution'] = 'Solution';
$string['solutionandtests'] = 'Solution et tests';
$string['solutionblocks'] = 'La solution a {$a} blocs, plus que cette limite.';
$string['solutionfails'] = 'La solution échoue au test {$a->n} : {$a->error}';
$string['solutiongrowth'] = 'Les pas de la solution croissent comme {$a}, plus vite que cette limite.';
$string['solutionnogrowth'] = 'La croissance de la solution ne peut pas être mesurée : il lui faut une taille n (une affectation comme n = 10, ou la première saisie) et elle doit s\'exécuter pour n = 10, 20 et 50.';
$string['stepfactor'] = 'Pas comparés à la solution';
$string['stepfactor_help'] = 'Dans chaque test, la réponse peut faire au plus ce nombre de fois les pas de la solution de l\'enseignant (0 : pas de limite). Avec 1.5, une réponse peut faire moitié plus de pas que la solution. Un pas est l\'exécution d\'un bloc, comme dans le compteur de pas de l\'éditeur.';
$string['stepfactorrange'] = 'Utilisez 0 pour aucune limite, ou un nombre à partir de 1.';
$string['structure_array'] = 'tableau';
$string['structure_dowhile'] = 'Boucle Faire';
$string['structure_for'] = 'Boucle Pour';
$string['structure_if'] = 'Si';
$string['structure_matrix'] = 'matrice';
$string['structure_record'] = 'enregistrement';
$string['structure_while'] = 'Boucle Tant que';
$string['structures'] = 'Structures requises';
$string['structures_help'] = 'Si la réponse n\'utilise pas chaque structure cochée ici, elle n\'obtient aucun point, même si les tests réussissent.';
$string['studenteditor'] = 'Éditeur de l\'élève';
$string['template'] = 'Modèle de départ';
$string['test'] = 'Test';
$string['testerror'] = 'Test {$a} : arrêté par une erreur';
$string['testfailed'] = 'Test {$a} : sortie différente';
$string['testpassed'] = 'Test {$a} : réussi';
$string['tests'] = 'Tests';
$string['tests_help'] = 'Ajoutez des tests et saisissez leurs entrées, une valeur par ligne ("" pour une valeur vide). Un test peut aussi appeler une des fonctions de l\'algorithme : choisissez la fonction et saisissez ses arguments, par exemple 2, 3 ; la valeur qu\'elle renvoie est comparée. Les sorties attendues sont calculées à partir de votre solution lors de l\'enregistrement de la question. Chaque test a un poids (1 sauf si vous le changez) : un test de poids 2 compte double. Les tests cachés sont notés, mais les élèves ne voient pas leurs entrées et sorties.';
$string['testssummary'] = 'Tests réussis : {$a->passed} sur {$a->total}';
$string['tolerance'] = 'Tolérance pour les nombres';
$string['tolerance_help'] = 'Les nombres de la sortie peuvent différer des nombres attendus d\'au plus cette valeur, par exemple 0.01. Le reste de la ligne doit être identique. 0 compare les nombres exactement.';
$string['tolerancenegative'] = 'La tolérance ne peut pas être négative.';
$string['toolarge'] = 'L\'algorithme est trop grand : il peut avoir au plus {$a} blocs.';
$string['usetemplate'] = 'Les élèves partent d\'un modèle séparé au lieu d\'un diagramme vide';
$string['weight'] = 'Poids';
