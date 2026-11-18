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
 * Strings for component 'qtype_algorithm', language 'pt' (Portuguese).
 *
 * @package    qtype_algorithm
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['afterinput'] = 'Apenas a saída depois da última entrada';
$string['aihints'] = 'Dicas da IA';
$string['aihints_desc'] = 'Os alunos podem pedir à IA do site dicas sobre erros e testes falhados';
$string['aihints_help'] = 'Com as dicas da IA ativas nas definições do plugin Editor de algoritmos e um fornecedor de IA no site, os alunos têm na tentativa os botões Explicar com IA (depois de um erro) e Dica da IA (junto a um teste falhado). A IA recebe o algoritmo do aluno como pseudocódigo, o erro ou o teste visível e o texto da pergunta, e tem a instrução de nunca dar a solução. Deixe desativado em exames.';
$string['answerlegend'] = 'O seu algoritmo';
$string['cachedef_results'] = 'Resultados dos testes das respostas Algoritmo';
$string['compare'] = 'O que é comparado';
$string['copyfromsolution'] = 'Copiar da solução';
$string['correctsolution'] = 'A solução do professor:';
$string['distractors'] = 'Blocos errados adicionais';
$string['distractors_help'] = 'Blocos feitos a partir de blocos da solução com um pequeno erro (< em vez de <=, - 1 em vez de + 1, or em vez de and, um número maior em um). Os alunos devem deixá-los de fora.';
$string['efficiency'] = 'Eficiência';
$string['efficiency_blocks'] = 'O algoritmo tem {$a->blocks} blocos; são permitidos no máximo {$a->max}.';
$string['efficiency_growth'] = 'Os passos do algoritmo crescem como {$a->growth}; é permitido no máximo {$a->max}.';
$string['efficiency_growthunknown'] = 'Não foi possível medir o crescimento do algoritmo: precisa de um tamanho n (uma atribuição como n = 10, ou a primeira entrada) e tem de executar para n = 10, 20 e 50.';
$string['efficiency_steps'] = 'Teste {$a->n}: o algoritmo deu {$a->steps} passos; são permitidos no máximo {$a->max}.';
$string['efficiencypenalty'] = 'Penalização para uma resposta não suficientemente eficiente (%)';
$string['efficiencypenalty_help'] = 'Quando a resposta passa nos testes mas não cumpre uma condição de eficiência (passos, crescimento ou blocos), esta percentagem é retirada da sua nota. 100 não dá pontos a essa resposta, 0 apenas mostra a mensagem.';
$string['efficiencypenaltyapplied'] = 'Por isso, são retirados {$a} % da nota.';
$string['efficiencypenaltyrange'] = 'A penalização é uma percentagem de 0 a 100.';
$string['emptytemplate'] = 'Vazio';
$string['expected'] = 'Esperado';
$string['failed'] = 'Falhou';
$string['gaps'] = 'Preencher lacunas';
$string['gaps_help'] = 'Se for maior que 0, os alunos não desenham o algoritmo: recebem a solução com este número de expressões e condições esvaziadas (escolhidas ao acaso no início da tentativa) e escrevem só as partes em falta. Os blocos não podem ser adicionados, movidos nem apagados. A resposta é avaliada com os testes. Não é usado num problema de Parsons.';
$string['gapsintro'] = 'Preencha as lacunas: escreva as expressões em falta nos blocos marcados com uma lacuna (___). Os blocos ficam onde estão.';
$string['got'] = 'A sua saída';
$string['grademethod'] = 'Nota';
$string['grademethod_all'] = 'Nota máxima apenas quando todos os testes passam';
$string['grademethod_proportional'] = 'Parte dos testes que passaram, segundo o seu peso';
$string['gradingnote'] = 'Com testes, a resposta é avaliada automaticamente: o algoritmo executa com as entradas de cada teste e a sua saída é comparada com a saída da sua solução. Sem testes, avalia a resposta manualmente.';
$string['growth_o1'] = '1 (constante)';
$string['growth_ologn'] = 'log n';
$string['growth_on'] = 'n (linear)';
$string['growth_on2'] = 'n² (quadrático)';
$string['growth_on3'] = 'n³ (cúbico)';
$string['growth_onlogn'] = 'n log n';
$string['hiddentest'] = 'Teste oculto';
$string['hidetools'] = 'Ocultar o código gerado e a importação e exportação de ficheiros';
$string['hidetools_help'] = 'Os alunos não veem o painel do código, a importação e exportação .fprg nem os botões de imagem no editor da tentativa. Isto desencoraja copiar código do diagrama (ou um diagrama de um ficheiro); não bloqueia nada. A revisão depois da tentativa mostra o código como habitualmente.';
$string['ignorecase'] = 'Maiúsculas e minúsculas são iguais';
$string['ignorespaces'] = 'Os espaços a mais não contam';
$string['inputs'] = 'Entrada';
$string['maxblocks'] = 'Máximo de blocos';
$string['maxblocks_help'] = 'A resposta pode ter no máximo este número de blocos em todas as suas funções (0: sem limite). Uma solução curta é muitas vezes mais clara.';
$string['maxblocksnegative'] = 'O número de blocos não pode ser negativo.';
$string['maxgrowth'] = 'Os passos podem crescer no máximo como';
$string['maxgrowth_help'] = 'A resposta executa para n = 10, 20, 50, 100, 200 e 500, os seus passos são contados, e o crescimento que melhor se ajusta não pode ser mais rápido do que o escolhido aqui (Complexidade no editor mede da mesma forma). O tamanho n é uma atribuição de um número inteiro como n = 10 na função principal, ou então o primeiro valor que o algoritmo lê; os outros valores lidos são números inteiros aleatórios.';
$string['maxgrowth_none'] = 'Sem limite';
$string['missingstructures'] = 'O algoritmo tem de usar: {$a}. A resposta não obtém pontos.';
$string['noalgorithm'] = 'Não foi submetido nenhum algoritmo.';
$string['noinput'] = 'O algoritmo pede mais entradas do que o teste fornece.';
$string['nosolution'] = 'Desenhe a solução: as saídas esperadas dos testes são calculadas a partir dela.';
$string['numbers'] = 'Apenas os números (o texto à volta pode ser qualquer)';
$string['numbers_help'] = 'Apenas os números da saída são comparados, por ordem, por isso os alunos podem escrever qualquer texto à volta. Com «Apenas a saída depois da última entrada», mensagens como «Introduza um número» também não contam.';
$string['ordercheck'] = 'Verificar a ordem';
$string['ordercheck_desc'] = 'Os alunos podem verificar a ordem dos seus blocos';
$string['ordercheck_help'] = 'Os alunos têm um botão Verificar a ordem: marca os blocos que não estão no seu lugar (no ciclo ou ramo errado, na ordem errada ou blocos errados a mais) sem executar o algoritmo. A solução não é mostrada. Verificar não tem custo, por isso use-o para praticar.';
$string['parsons'] = 'Problema de Parsons';
$string['parsons_desc'] = 'Os alunos recebem os blocos da solução por ordem aleatória e ordenam-nos';
$string['parsons_help'] = 'Os alunos não desenham o algoritmo: recebem todos os blocos da solução, por ordem aleatória, com os ciclos e os ramos vazios, e movem os blocos para os seus lugares. Não podem adicionar blocos nem mudar o seu texto. A resposta é avaliada com os testes, como qualquer outra. O modelo inicial não é usado.';
$string['parsonsintro'] = 'Ordene os blocos dados: mova cada bloco para o seu lugar (também dentro de ciclos e ramos) e apague os blocos que não pertencem.';
$string['passed'] = 'Passou';
$string['pleasedrawalgorithm'] = 'Desenhe um algoritmo: adicione pelo menos um bloco.';
$string['pluginname'] = 'Algoritmo';
$string['pluginname_help'] = 'O aluno desenha um algoritmo como fluxograma na pergunta e pode executá-lo. Com testes, a resposta é avaliada automaticamente; sem testes, o professor avalia-a.';
$string['pluginnameadding'] = 'A adicionar uma pergunta Algoritmo';
$string['pluginnameediting'] = 'A editar uma pergunta Algoritmo';
$string['pluginnamesummary'] = 'O aluno desenha um algoritmo como fluxograma e pode executá-lo. Avaliado automaticamente com testes calculados a partir da solução do professor, ou manualmente.';
$string['privacy:metadata'] = 'O tipo de pergunta Algoritmo não guarda dados pessoais. As respostas são guardadas pelo motor de perguntas do Moodle. O navegador guarda algumas definições de visualização (código e variáveis mostrados ou ocultos) no seu armazenamento local.';
$string['responsesummary'] = 'Algoritmo com {$a->blocks} bloco(s) em {$a->functions} função(ões)';
$string['rule_aihints'] = 'Pode pedir uma dica à IA depois de um erro ou de um teste falhado; ela não dá a solução.';
$string['rule_ignorecase'] = 'Maiúsculas e minúsculas são iguais.';
$string['rule_ignorespaces'] = 'Os espaços a mais não contam.';
$string['rule_maxblocks'] = 'No máximo {$a} blocos.';
$string['rule_maxgrowth'] = 'Os passos têm de crescer no máximo como {$a}.';
$string['rule_numbers'] = 'Os testes comparam apenas os números que o seu algoritmo escreve, por ordem.';
$string['rule_numbersafter'] = 'Os testes comparam apenas os números que o seu algoritmo escreve depois da última entrada, por ordem; o texto à volta pode ser qualquer.';
$string['rule_stepfactor'] = 'Em cada teste, no máximo {$a} vezes os passos da solução do professor.';
$string['rule_strictinit'] = 'Cada variável, elemento de vetor e campo tem de receber um valor antes de ser usado.';
$string['rule_structures'] = 'O algoritmo tem de usar: {$a}.';
$string['rule_text'] = 'Os testes comparam tudo o que o seu algoritmo escreve.';
$string['rule_textafter'] = 'Os testes comparam o que o seu algoritmo escreve depois da última entrada.';
$string['rule_tolerance'] = 'Os números podem diferir em {$a}.';
$string['showtests'] = 'Testes na tentativa';
$string['showtests_desc'] = 'Os alunos podem executar os testes não ocultos enquanto trabalham';
$string['solution'] = 'Solução';
$string['solutionandtests'] = 'Solução e testes';
$string['solutionblocks'] = 'A solução tem {$a} blocos, mais do que este limite.';
$string['solutionfails'] = 'A solução falha no teste {$a->n}: {$a->error}';
$string['solutiongrowth'] = 'Os passos da solução crescem como {$a}, mais depressa do que este limite.';
$string['solutionnogrowth'] = 'Não é possível medir o crescimento da solução: precisa de um tamanho n (uma atribuição como n = 10, ou a primeira entrada) e tem de executar para n = 10, 20 e 50.';
$string['stepfactor'] = 'Passos comparados com a solução';
$string['stepfactor_help'] = 'Em cada teste a resposta pode dar no máximo este número de vezes os passos da solução do professor (0: sem limite). Com 1.5 uma resposta pode precisar de metade dos passos a mais do que a solução. Um passo é um bloco executado, como no contador de passos do editor.';
$string['stepfactorrange'] = 'Use 0 para sem limite, ou um número a partir de 1.';
$string['strictinit'] = 'Inicialização estrita';
$string['strictinit_desc'] = 'Uma variável tem de receber um valor antes de ser usada';
$string['strictinit_help'] = 'Como em C, C++ e Java: ler uma variável, um elemento de um vetor ou um campo antes de ter valor para o algoritmo com um erro (nas execuções do aluno e na avaliação), e o código gerado em C, C++, Java e C# declara as variáveis sem valor inicial. Sem esta opção uma variável declarada começa com 0, texto vazio ou false.';
$string['structure_array'] = 'vetor';
$string['structure_dowhile'] = 'Ciclo Faça';
$string['structure_for'] = 'Ciclo Para';
$string['structure_if'] = 'Se';
$string['structure_matrix'] = 'matriz';
$string['structure_record'] = 'registo';
$string['structure_while'] = 'Ciclo Enquanto';
$string['structures'] = 'Estruturas obrigatórias';
$string['structures_help'] = 'Se a resposta não usar todas as estruturas marcadas aqui, não obtém pontos, mesmo que passe nos testes.';
$string['studenteditor'] = 'Editor do aluno';
$string['template'] = 'Modelo inicial';
$string['test'] = 'Teste';
$string['testerror'] = 'Teste {$a}: parou com um erro';
$string['testfailed'] = 'Teste {$a}: saída diferente';
$string['testpassed'] = 'Teste {$a}: passou';
$string['tests'] = 'Testes';
$string['tests_help'] = 'Adicione testes e escreva as suas entradas, um valor por linha ("" para um valor vazio). Um teste também pode chamar uma das funções do algoritmo: escolha a função e escreva os seus argumentos, por exemplo 2, 3; o valor que devolve é comparado. As saídas esperadas são calculadas a partir da sua solução quando a pergunta é guardada. Cada teste tem um peso (1, a menos que o mude): um teste com peso 2 conta a dobrar. Os testes ocultos são avaliados, mas os alunos não veem as suas entradas e saídas.';
$string['testssummary'] = 'Testes que passaram: {$a->passed} de {$a->total}';
$string['tolerance'] = 'Tolerância para números';
$string['tolerance_help'] = 'Os números da saída podem diferir dos esperados no máximo nesta quantidade, por exemplo 0.01. O resto da linha tem de ser igual. 0 compara os números exatamente.';
$string['tolerancenegative'] = 'A tolerância não pode ser negativa.';
$string['toolarge'] = 'O algoritmo é demasiado grande: pode ter no máximo {$a} blocos.';
$string['usetemplate'] = 'Os alunos começam a partir de um modelo separado em vez de um diagrama vazio';
$string['weight'] = 'Peso';
