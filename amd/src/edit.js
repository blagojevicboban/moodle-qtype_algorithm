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
 * Question editing form: flowchart editors for the solution and the starting template, and the tests
 * (the expected outputs are shown from the solution here and computed again on the server when the question is saved).
 *
 * @module     qtype_algorithm/edit
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
import {AlgorithmEditor} from 'tiny_algorithm/editor';
import {TestsPanel, cleanTest} from 'tiny_algorithm/tests';
import {cloneProgram, createProgram, deserialize, serialize} from 'tiny_algorithm/model';
import {getString} from 'core/str';
import {workspace} from 'qtype_algorithm/fullscreen';
import {load as loadStrings} from 'tiny_algorithm/langstrings';

/**
 * Algorithm stored in a hidden field, or null.
 *
 * @param {HTMLInputElement} input hidden field
 * @returns {object|null}
 */
const load = (input) => {
    try {
        return input.value ? deserialize(input.value) : null;
    } catch (e) {
        return null;
    }
};

/**
 * Tests stored in the hidden field.
 *
 * @param {HTMLInputElement} input hidden field
 * @returns {Array}
 */
const loadTests = (input) => {
    try {
        const tests = JSON.parse(input.value || '[]');
        return Array.isArray(tests) ? tests.filter((tc) => tc && typeof tc === 'object').map(cleanTest) : [];
    } catch (e) {
        return [];
    }
};

/**
 * Set up the form.
 *
 * @param {string} lang language code
 */
export const init = async(lang) => {
    await loadStrings();
    const field = (name) => document.querySelector(`input[name="${name}"]`);
    const solutionInput = field('solution');
    const templateInput = field('template');
    const testsInput = field('tests');
    const useTemplate = document.querySelector('input[type="checkbox"][name="usetemplate"]');
    const box = (name) => document.querySelector(`input[type="checkbox"][name="${name}"]`);
    const options = ['afterinput', 'numbers', 'ignorecase', 'ignorespaces'].map(box);
    const tolerance = field('tolerance');
    const solutionHost = document.getElementById('qtype_algorithm_solution');
    const templateHost = document.getElementById('qtype_algorithm_template');
    const testsHost = document.getElementById('qtype_algorithm_tests');
    if (!solutionInput || !solutionHost || !testsHost) {
        return;
    }

    let solution = null;
    workspace(solutionHost, lang, () => solution.zoom.autoFit());
    solution = new AlgorithmEditor(solutionHost, {program: load(solutionInput), lang, onChange: (program) => {
        solutionInput.value = serialize(program);
    }});
    solutionInput.value = serialize(solution.getProgram());

    // What the tests compare, from the options of the form.
    const check = () => ({
        ...Object.fromEntries(options.map((b, i) => [['afterinput', 'numbers', 'ignorecase', 'ignorespaces'][i],
            Boolean(b && b.checked)])),
        tolerance: Math.max(0, Number(tolerance && tolerance.value) || 0),
    });
    const saveTests = (tests) => {
        testsInput.value = JSON.stringify(tests.map((tc) => {
            const stored = cleanTest(tc);
            delete stored.expected; // The server computes the expected outputs again.
            return {...stored, hidden: Boolean(tc.hidden)};
        }));
    };
    const panel = new TestsPanel(testsHost, {tests: loadTests(testsInput), mode: 'teacher', lang, check: check(),
        getSolution: () => solution.getProgram(), hiddenOption: true, weightOption: true, onChange: saveTests});
    saveTests(panel.tests);
    [...options, tolerance].forEach((input) => input && input.addEventListener('change', () => {
        panel.check = check();
        panel.refreshExpected();
    }));

    // Starting template: its own editor, shown when the teacher ticks the option.
    let template = null;
    const [copyLabel, emptyLabel] = await Promise.all([
        getString('copyfromsolution', 'qtype_algorithm'), getString('emptytemplate', 'qtype_algorithm')]);
    const button = (label, onclick) => {
        const b = document.createElement('button');
        b.type = 'button';
        b.className = 'btn btn-secondary btn-sm me-2 mr-2 mb-2';
        b.textContent = label;
        b.addEventListener('click', onclick);
        return b;
    };
    const showTemplate = () => {
        const on = Boolean(useTemplate && useTemplate.checked);
        templateHost.hidden = !on;
        if (on && !template) {
            const bar = document.createElement('div');
            const host = document.createElement('div');
            templateHost.append(bar, host);
            workspace(host, lang, () => template.zoom.autoFit());
            template = new AlgorithmEditor(host, {program: load(templateInput) || cloneProgram(solution.getProgram()), lang,
                onChange: (program) => {
                    templateInput.value = serialize(program);
                }});
            bar.append(button(copyLabel, () => template.setProgram(cloneProgram(solution.getProgram()))),
                button(emptyLabel, () => template.setProgram(createProgram())));
            templateInput.value = serialize(template.getProgram());
        }
    };
    if (useTemplate && templateHost) {
        useTemplate.addEventListener('change', showTemplate);
        showTemplate();
    }
};
