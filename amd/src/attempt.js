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
 * Flowchart editor (attempt) or runnable diagram (review) for the Algorithm question type.
 *
 * @module     qtype_algorithm/attempt
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
import {AlgorithmEditor} from 'tiny_algorithm/editor';
import {AlgorithmRunner} from 'tiny_algorithm/runner';
import {TestsPanel} from 'tiny_algorithm/tests';
import {deserialize, serialize} from 'tiny_algorithm/model';
import {workspace} from 'qtype_algorithm/fullscreen';
import {load as loadStrings} from 'tiny_algorithm/langstrings';
import {openClassView} from 'tiny_algorithm/classview';
import {showToast} from 'tiny_algorithm/dialog';
import {t} from 'tiny_algorithm/strings';
import Ajax from 'core/ajax';

/**
 * Algorithm from its encoded form, or null.
 *
 * @param {string} text base64 encoded JSON
 * @returns {object|null}
 */
const decode = (text) => {
    try {
        return text ? deserialize(text) : null;
    } catch (e) {
        return null;
    }
};

/**
 * Number of blocks in the whole program, nested blocks included.
 *
 * @param {object} program the algorithm model
 * @returns {number}
 */
const countBlocks = (program) => {
    const count = (list) => list.reduce((sum, block) => sum + 1 + ['then', 'else', 'body']
        .reduce((inner, key) => inner + (Array.isArray(block[key]) ? count(block[key]) : 0), 0), 0);
    return program.functions.reduce((sum, fn) => sum + count(fn.body), 0);
};

/**
 * Add the Class work button (the teacher in a quiz): the answers of the students as small diagrams.
 *
 * @param {{root: HTMLElement, button: Function}} ws the toolbar of the question
 * @param {{cmid: number, slot: number}} classwork the quiz and the slot of the question
 * @param {string} lang language code
 * @param {Array} tests tests shown with the question
 * @param {Object} codeConfig code languages
 */
const addClassWork = (ws, classwork, lang, tests, codeConfig) => {
    const load = () => Ajax.call([{methodname: 'qtype_algorithm_get_class_answers',
        args: {cmid: classwork.cmid, slot: classwork.slot}}])[0].then((r) => r.answers);
    const analyse = () => Ajax.call([{methodname: 'qtype_algorithm_get_class_analysis',
        args: {cmid: classwork.cmid, slot: classwork.slot}}])[0];
    ws.button('classwork', () => openClassView(ws.root, {load, tests, lang, codeConfig, analyse}));
};

/**
 * Check order of a Parsons problem: the server says which blocks are not in their place; they are marked until the
 * diagram is drawn again.
 *
 * @param {{root: HTMLElement, button: Function}} ws the toolbar of the question
 * @param {HTMLElement} container the editor
 * @param {Function} current returns the current arrangement (base64 encoded JSON)
 * @param {{usageid: number, slot: number}} where the attempt and the slot of the question
 */
const addOrderCheck = (ws, container, current, where) => {
    const check = async() => {
        try {
            const r = await Ajax.call([{methodname: 'qtype_algorithm_check_order',
                args: {usageid: where.usageid, slot: where.slot, answer: current()}}])[0];
            container.querySelectorAll('.tiny_algorithm-misplaced').forEach((n) => n.classList.remove('tiny_algorithm-misplaced'));
            r.wrong.forEach((id) => {
                const node = container.querySelector(`.tiny_algorithm-node[data-id="${CSS.escape(id)}"]`);
                if (node) {
                    node.classList.add('tiny_algorithm-misplaced');
                }
            });
            showToast(ws.root, r.wrong.length ? t('orderresult', {placed: String(r.placed), total: String(r.total)})
                : t('orderdone'));
        } catch (e) {
            showToast(ws.root, t('ordererror'));
        }
    };
    ws.button('checkorder', check);
};

/**
 * Initialise the question.
 *
 * @param {string} containerId id of the element that receives the editor or the viewer
 * @param {string} inputId id of the hidden input that carries the answer
 * @param {boolean} readonly true when the response can no longer be changed
 * @param {string} lang language code
 * @param {string} emptyText text shown when the review has no answer
 * @param {object} [options]
 * @param {string} [options.template] algorithm to start from (base64 encoded JSON)
 * @param {Array} [options.tests] tests the student may run (inputs, expected)
 * @param {object} [options.check] what the tests compare (afterinput, numbers)
 * @param {boolean} [options.hidetools] hide the generated code and the file import and export
 * @param {boolean} [options.parsons] a Parsons problem: the given blocks are only moved, nested and deleted
 * @param {boolean} [options.gaps] a fill-the-gaps problem: only the emptied expressions of the blocks are typed
 * @param {Object} [options.codeConfig] code languages of the site, the course and the question
 * @param {Object|null} [options.ordercheck] the attempt and slot of a Parsons problem whose order can be checked
 * @param {Object|null} [options.classwork] the quiz and slot of the question, for a teacher who may see the answers of the class
 */
export const init = async(containerId, inputId, readonly, lang, emptyText,
        {template = '', tests = [], check = {}, hidetools = false, codeConfig = {}, parsons = false, gaps = false,
            classwork = null, ordercheck = null} = {}) => {
    await loadStrings();
    const container = document.getElementById(containerId);
    const input = document.getElementById(inputId);
    if (!container || !input) {
        return;
    }
    const program = decode(input.value);

    if (readonly) {
        if (classwork) {
            addClassWork(workspace(container, lang), classwork, lang, tests, codeConfig);
        }
        if (program) {
            new AlgorithmRunner(container, program, {lang, codeConfig});
        } else {
            container.textContent = emptyText;
        }
        return;
    }

    // Toolbar above the editor (Test, Full screen); the editor and the tests go full screen together.
    let editor = null;
    const ws = workspace(container, lang, () => editor.zoom.autoFit());

    let panel = null;
    // The editor reports its first drawing too: that is not a change by the student (opening a question with a
    // template must not answer it, and a saved answer must not be marked as changed).
    // The editor also draws again during Run and Step, so a drawing is a change only when the algorithm differs from the
    // last one (stepping through the template must not answer the question or make the test results old).
    let last = null;
    editor = new AlgorithmEditor(container, {
        program: program || decode(template),
        lang,
        showCode: !hidetools,
        // A Parsons or fill-the-gaps problem has no file tools (an imported diagram would replace the given blocks).
        fileTools: !hidetools && !parsons && !gaps,
        codeConfig,
        parsons,
        gaps,
        onChange: (current) => {
            const now = serialize(current);
            if (last === null || now === last) {
                return;
            }
            last = now;
            // An empty diagram counts as no answer, so the question is reported as not complete.
            const value = countBlocks(current) > 0 ? now : '';
            if (input.value !== value) {
                input.value = value;
                input.dispatchEvent(new Event('change', {bubbles: true}));
            }
            if (panel) {
                panel.markStale();
            }
        },
    });
    last = serialize(editor.getProgram());
    if (tests.length) {
        const host = document.createElement('div');
        host.className = 'qtype_algorithm_tests';
        container.after(host);
        panel = new TestsPanel(host, {tests, mode: 'student', lang, check, getProgram: () => editor.getProgram(), codeConfig,
            // A failed test: step through the algorithm with its inputs.
            onRunInputs: (values) => {
                editor.startWithInputs(values);
                container.scrollIntoView({block: 'nearest', behavior: 'smooth'});
            }});
        ws.bar.prepend(ws.button('runtests', () => {
            panel.run();
            host.scrollIntoView({block: 'nearest', behavior: 'smooth'});
        }, 'btn-primary'));
    }
    if (ordercheck) {
        addOrderCheck(ws, container, () => serialize(editor.getProgram()), ordercheck);
    }
    if (classwork) {
        addClassWork(ws, classwork, lang, tests, codeConfig);
    }
};

/**
 * Show the teacher's solution (review): a runnable diagram.
 *
 * @param {string} containerId id of the element that receives the diagram
 * @param {string} solution the solution (base64 encoded JSON)
 * @param {string} lang language code
 * @param {Object} [codeConfig] code languages of the site, the course and the question
 */
export const showSolution = async(containerId, solution, lang, codeConfig = {}) => {
    await loadStrings();
    const container = document.getElementById(containerId);
    const program = decode(solution);
    if (container && program) {
        new AlgorithmRunner(container, program, {lang, codeConfig});
    }
};
