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
 */
export const init = async(containerId, inputId, readonly, lang, emptyText,
        {template = '', tests = [], check = {}, hidetools = false} = {}) => {
    await loadStrings();
    const container = document.getElementById(containerId);
    const input = document.getElementById(inputId);
    if (!container || !input) {
        return;
    }
    const program = decode(input.value);

    if (readonly) {
        if (program) {
            new AlgorithmRunner(container, program, {lang});
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
        fileTools: !hidetools,
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
        panel = new TestsPanel(host, {tests, mode: 'student', lang, check, getProgram: () => editor.getProgram()});
        ws.bar.prepend(ws.button('runtests', () => {
            panel.run();
            host.scrollIntoView({block: 'nearest', behavior: 'smooth'});
        }, 'btn-primary'));
    }
};

/**
 * Show the teacher's solution (review): a runnable diagram.
 *
 * @param {string} containerId id of the element that receives the diagram
 * @param {string} solution the solution (base64 encoded JSON)
 * @param {string} lang language code
 */
export const showSolution = async(containerId, solution, lang) => {
    await loadStrings();
    const container = document.getElementById(containerId);
    const program = decode(solution);
    if (container && program) {
        new AlgorithmRunner(container, program, {lang});
    }
};
