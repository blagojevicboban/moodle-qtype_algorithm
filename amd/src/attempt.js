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
import {deserialize, serialize} from 'tiny_algorithm/model';

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
 */
export const init = (containerId, inputId, readonly, lang, emptyText) => {
    const container = document.getElementById(containerId);
    const input = document.getElementById(inputId);
    if (!container || !input) {
        return;
    }
    let program = null;
    if (input.value) {
        try {
            program = deserialize(input.value);
        } catch (e) {
            program = null;
        }
    }

    if (readonly) {
        if (program) {
            new AlgorithmRunner(container, program, {lang});
        } else {
            container.textContent = emptyText;
        }
        return;
    }

    new AlgorithmEditor(container, {
        program,
        lang,
        onChange: (current) => {
            // An empty diagram counts as no answer, so the question is reported as not complete.
            const value = countBlocks(current) > 0 ? serialize(current) : '';
            if (input.value !== value) {
                input.value = value;
                input.dispatchEvent(new Event('change', {bubbles: true}));
            }
        },
    });
};
