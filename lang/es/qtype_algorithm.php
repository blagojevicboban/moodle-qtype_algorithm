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
 * Strings for component 'qtype_algorithm', language 'es' (Spanish).
 *
 * @package    qtype_algorithm
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['afterinput'] = 'Solo la salida después de la última entrada';
$string['aihints'] = 'Pistas de la IA';
$string['aihints_desc'] = 'Los estudiantes pueden pedir a la IA del sitio pistas sobre errores y pruebas fallidas';
$string['aihints_help'] = 'Con las pistas de la IA activadas en los ajustes del plugin Editor de algoritmos y un proveedor de IA en el sitio, los estudiantes tienen en el intento los botones Explicar con IA (después de un error) y Pista de la IA (junto a una prueba fallida). La IA recibe el algoritmo del estudiante como pseudocódigo, el error o la prueba visible y el texto de la pregunta, y tiene la instrucción de no dar nunca la solución. Déjelo desactivado en los exámenes.';
$string['answerlegend'] = 'Su algoritmo';
$string['cachedef_results'] = 'Resultados de las pruebas de las respuestas Algoritmo';
$string['compare'] = 'Qué se compara';
$string['copyfromsolution'] = 'Copiar de la solución';
$string['correctsolution'] = 'La solución del profesor:';
$string['distractors'] = 'Bloques incorrectos adicionales';
$string['distractors_help'] = 'Bloques hechos a partir de bloques de la solución con un pequeño error (< en lugar de <=, - 1 en lugar de + 1, or en lugar de and, un número mayor en uno). Los estudiantes deben dejarlos fuera.';
$string['efficiency'] = 'Eficiencia';
$string['efficiency_blocks'] = 'El algoritmo tiene {$a->blocks} bloques; se permiten como máximo {$a->max}.';
$string['efficiency_growth'] = 'Los pasos del algoritmo crecen como {$a->growth}; se permite como máximo {$a->max}.';
$string['efficiency_growthunknown'] = 'No se pudo medir el crecimiento del algoritmo: necesita un tamaño n (una asignación como n = 10, o la primera entrada) y debe ejecutarse para n = 10, 20 y 50.';
$string['efficiency_steps'] = 'Prueba {$a->n}: el algoritmo dio {$a->steps} pasos; se permiten como máximo {$a->max}.';
$string['efficiencypenalty'] = 'Penalización para una respuesta no suficientemente eficiente (%)';
$string['efficiencypenalty_help'] = 'Cuando la respuesta pasa las pruebas pero incumple una condición de eficiencia (pasos, crecimiento o bloques), este porcentaje se resta de su calificación. 100 no da puntos a esa respuesta, 0 solo muestra el mensaje.';
$string['efficiencypenaltyapplied'] = 'Por esto se resta un {$a} % de la calificación.';
$string['efficiencypenaltyrange'] = 'La penalización es un porcentaje de 0 a 100.';
$string['emptytemplate'] = 'Vacío';
$string['expected'] = 'Esperado';
$string['failed'] = 'Fallida';
$string['gaps'] = 'Completar huecos';
$string['gaps_help'] = 'Si es mayor que 0, los estudiantes no dibujan el algoritmo: reciben la solución con este número de expresiones y condiciones vaciadas (elegidas al azar al empezar el intento) y escriben solo las partes que faltan. Los bloques no se pueden añadir, mover ni borrar. La respuesta se califica con las pruebas. No se usa en un problema de Parsons.';
$string['gapsintro'] = 'Completa los huecos: escribe las expresiones que faltan en los bloques marcados con un hueco (___). Los bloques se quedan donde están.';
$string['got'] = 'Su salida';
$string['grademethod'] = 'Calificación';
$string['grademethod_all'] = 'Nota completa solo cuando pasan todas las pruebas';
$string['grademethod_proportional'] = 'Proporción de pruebas superadas, según su peso';
$string['gradingnote'] = 'Con pruebas, la respuesta se califica automáticamente: el algoritmo se ejecuta con las entradas de cada prueba y su salida se compara con la salida de su solución. Sin pruebas, usted califica la respuesta manualmente.';
$string['growth_o1'] = '1 (constante)';
$string['growth_ologn'] = 'log n';
$string['growth_on'] = 'n (lineal)';
$string['growth_on2'] = 'n² (cuadrático)';
$string['growth_on3'] = 'n³ (cúbico)';
$string['growth_onlogn'] = 'n log n';
$string['hiddentest'] = 'Prueba oculta';
$string['hidetools'] = 'Ocultar el código generado y la importación y exportación de archivos';
$string['hidetools_help'] = 'Los estudiantes no ven el panel del código, la importación y exportación .fprg ni los botones de imagen en el editor del intento. Esto desanima a copiar código del diagrama (o un diagrama de un archivo); no bloquea nada. La revisión después del intento muestra el código como siempre.';
$string['ignorecase'] = 'Mayúsculas y minúsculas son iguales';
$string['ignorespaces'] = 'Los espacios de más no cuentan';
$string['inputs'] = 'Entrada';
$string['maxblocks'] = 'Máximo de bloques';
$string['maxblocks_help'] = 'La respuesta puede tener como máximo este número de bloques en todas sus funciones (0: sin límite). Una solución corta suele ser más clara.';
$string['maxblocksnegative'] = 'El número de bloques no puede ser negativo.';
$string['maxgrowth'] = 'Los pasos pueden crecer como máximo como';
$string['maxgrowth_help'] = 'La respuesta se ejecuta para n = 10, 20, 50, 100, 200 y 500, se cuentan sus pasos, y el crecimiento que mejor se ajusta no debe ser más rápido que el elegido aquí (Complejidad en el editor mide de la misma forma). El tamaño n es una asignación de un número entero como n = 10 en la función principal, o si no el primer valor que lee el algoritmo; los demás valores que lee son números enteros aleatorios.';
$string['maxgrowth_none'] = 'Sin límite';
$string['missingstructures'] = 'El algoritmo debe usar: {$a}. La respuesta no obtiene puntos.';
$string['noalgorithm'] = 'No se envió ningún algoritmo.';
$string['noinput'] = 'El algoritmo pide más entradas de las que da la prueba.';
$string['nosolution'] = 'Dibuje la solución: las salidas esperadas de las pruebas se calculan a partir de ella.';
$string['numbers'] = 'Solo los números (el texto alrededor puede ser cualquiera)';
$string['numbers_help'] = 'Solo se comparan los números de la salida, en orden, así que los estudiantes pueden escribir cualquier texto alrededor. Con «Solo la salida después de la última entrada», los mensajes como «Introduzca un número» tampoco cuentan.';
$string['ordercheck'] = 'Comprobar el orden';
$string['ordercheck_desc'] = 'Los estudiantes pueden comprobar el orden de sus bloques';
$string['ordercheck_help'] = 'Los estudiantes tienen un botón Comprobar el orden: marca los bloques que no están en su lugar (en el bucle o la rama equivocada, en el orden equivocado o bloques incorrectos de más) sin ejecutar el algoritmo. No se muestra la solución. Comprobar no tiene coste, así que úselo para practicar.';
$string['parsons'] = 'Problema de Parsons';
$string['parsons_desc'] = 'Los estudiantes reciben los bloques de la solución en orden aleatorio y los ordenan';
$string['parsons_help'] = 'Los estudiantes no dibujan el algoritmo: reciben todos los bloques de la solución, en orden aleatorio, con los bucles y las ramas vacíos, y mueven los bloques a su lugar. No pueden añadir bloques ni cambiar su texto. La respuesta se califica con las pruebas, como cualquier otra. No se usa la plantilla inicial.';
$string['parsonsintro'] = 'Ordene los bloques dados: mueva cada bloque a su lugar (también dentro de bucles y ramas) y elimine los bloques que no corresponden.';
$string['passed'] = 'Superada';
$string['pleasedrawalgorithm'] = 'Dibuje un algoritmo: añada al menos un bloque.';
$string['pluginname'] = 'Algoritmo';
$string['pluginname_help'] = 'El estudiante dibuja un algoritmo como diagrama de flujo en la pregunta y puede ejecutarlo. Con pruebas, la respuesta se califica automáticamente; sin pruebas, la califica el profesor.';
$string['pluginnameadding'] = 'Añadiendo una pregunta Algoritmo';
$string['pluginnameediting'] = 'Editando una pregunta Algoritmo';
$string['pluginnamesummary'] = 'El estudiante dibuja un algoritmo como diagrama de flujo y puede ejecutarlo. Se califica automáticamente con pruebas calculadas a partir de la solución del profesor, o manualmente.';
$string['privacy:metadata'] = 'El tipo de pregunta Algoritmo no guarda datos personales. Las respuestas las guarda el motor de preguntas de Moodle. El navegador guarda algunos ajustes de visualización (código y variables mostrados u ocultos) en su almacenamiento local.';
$string['responsesummary'] = 'Algoritmo con {$a->blocks} bloque(s) en {$a->functions} función(es)';
$string['rule_aihints'] = 'Puede pedir una pista a la IA después de un error o una prueba fallida; no da la solución.';
$string['rule_ignorecase'] = 'Mayúsculas y minúsculas son iguales.';
$string['rule_ignorespaces'] = 'Los espacios de más no cuentan.';
$string['rule_maxblocks'] = 'Como máximo {$a} bloques.';
$string['rule_maxgrowth'] = 'Los pasos deben crecer como máximo como {$a}.';
$string['rule_numbers'] = 'Las pruebas comparan solo los números que escribe su algoritmo, en orden.';
$string['rule_numbersafter'] = 'Las pruebas comparan solo los números que escribe su algoritmo después de la última entrada, en orden; el texto alrededor puede ser cualquiera.';
$string['rule_stepfactor'] = 'En cada prueba, como máximo {$a} veces los pasos de la solución del profesor.';
$string['rule_structures'] = 'El algoritmo debe usar: {$a}.';
$string['rule_text'] = 'Las pruebas comparan todo lo que escribe su algoritmo.';
$string['rule_textafter'] = 'Las pruebas comparan lo que escribe su algoritmo después de la última entrada.';
$string['rule_tolerance'] = 'Los números pueden diferir en {$a}.';
$string['showtests'] = 'Pruebas en el intento';
$string['showtests_desc'] = 'Los estudiantes pueden ejecutar las pruebas no ocultas mientras trabajan';
$string['solution'] = 'Solución';
$string['solutionandtests'] = 'Solución y pruebas';
$string['solutionblocks'] = 'La solución tiene {$a} bloques, más que este límite.';
$string['solutionfails'] = 'La solución falla en la prueba {$a->n}: {$a->error}';
$string['solutiongrowth'] = 'Los pasos de la solución crecen como {$a}, más rápido que este límite.';
$string['solutionnogrowth'] = 'No se puede medir el crecimiento de la solución: necesita un tamaño n (una asignación como n = 10, o la primera entrada) y debe ejecutarse para n = 10, 20 y 50.';
$string['stepfactor'] = 'Pasos comparados con la solución';
$string['stepfactor_help'] = 'En cada prueba, la respuesta puede dar como máximo este número de veces los pasos de la solución del profesor (0: sin límite). Con 1.5 una respuesta puede necesitar la mitad de pasos más que la solución. Un paso es un bloque ejecutado, como en el contador de pasos del editor.';
$string['stepfactorrange'] = 'Use 0 para ningún límite, o un número desde 1.';
$string['structure_array'] = 'arreglo';
$string['structure_dowhile'] = 'Bucle Hacer';
$string['structure_for'] = 'Bucle Para';
$string['structure_if'] = 'Si';
$string['structure_matrix'] = 'matriz';
$string['structure_record'] = 'registro';
$string['structure_while'] = 'Bucle Mientras';
$string['structures'] = 'Estructuras requeridas';
$string['structures_help'] = 'Si la respuesta no usa todas las estructuras marcadas aquí, no obtiene puntos, aunque pase las pruebas.';
$string['studenteditor'] = 'Editor del estudiante';
$string['template'] = 'Plantilla inicial';
$string['test'] = 'Prueba';
$string['testerror'] = 'Prueba {$a}: se detuvo con un error';
$string['testfailed'] = 'Prueba {$a}: salida distinta';
$string['testpassed'] = 'Prueba {$a}: superada';
$string['tests'] = 'Pruebas';
$string['tests_help'] = 'Añada pruebas y escriba sus entradas, un valor por línea ("" para un valor vacío). Una prueba también puede llamar a una de las funciones del algoritmo: elija la función y escriba sus argumentos, por ejemplo 2, 3; se compara el valor que devuelve. Las salidas esperadas se calculan a partir de su solución al guardar la pregunta. Cada prueba tiene un peso (1 salvo que lo cambie): una prueba con peso 2 cuenta doble. Las pruebas ocultas se califican, pero los estudiantes no ven sus entradas ni salidas.';
$string['testssummary'] = 'Pruebas superadas: {$a->passed} de {$a->total}';
$string['tolerance'] = 'Tolerancia para los números';
$string['tolerance_help'] = 'Los números de la salida pueden diferir de los esperados como máximo en esta cantidad, por ejemplo 0.01. El resto de la línea debe ser igual. 0 compara los números exactamente.';
$string['tolerancenegative'] = 'La tolerancia no puede ser negativa.';
$string['toolarge'] = 'El algoritmo es demasiado grande: puede tener como máximo {$a} bloques.';
$string['usetemplate'] = 'Los estudiantes empiezan desde una plantilla aparte en lugar de un diagrama vacío';
$string['weight'] = 'Peso';
