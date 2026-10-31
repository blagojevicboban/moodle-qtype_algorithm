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
 * Full screen for a flowchart editor: through the browser when possible, otherwise by covering the window
 * (the same look as the student workspace of tiny_algorithm).
 *
 * @module     qtype_algorithm/fullscreen
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
import {t as tr} from 'tiny_algorithm/strings';

/**
 * Wrap an element in a workspace with a toolbar; the element and everything added to the workspace go full screen together.
 *
 * @param {HTMLElement} element element to wrap (e.g. the editor's container)
 * @param {string} lang language code
 * @param {Function} [onResize] called after the size changed (e.g. to fit the diagram)
 * @returns {{root: HTMLElement, bar: HTMLElement, button: Function}} the workspace, its toolbar and a helper that adds a button
 */
export const workspace = (element, lang, onResize = null) => {
    const root = document.createElement('div');
    root.className = 'alg-workspace qtype_algorithm_workspace';
    root.tabIndex = -1;
    const bar = document.createElement('div');
    bar.className = 'alg-ws-bar';
    element.before(root);
    root.append(bar, element);

    const button = (key, onclick, cls = 'btn-secondary') => {
        const b = document.createElement('button');
        b.type = 'button';
        b.className = `btn ${cls} btn-sm`;
        b.textContent = tr(key, lang);
        b.addEventListener('click', onclick);
        bar.append(b);
        return b;
    };

    let full = null;
    const setFullscreen = (on) => {
        root.classList.toggle('alg-fullscreen', on);
        full.textContent = tr(on ? 'exitfullscreen' : 'fullscreen', lang);
        full.setAttribute('aria-pressed', on ? 'true' : 'false');
        if (on) {
            root.focus();
        }
        if (onResize) {
            requestAnimationFrame(onResize);
        }
    };
    full = button('fullscreen', () => {
        const on = !root.classList.contains('alg-fullscreen');
        if (on && root.requestFullscreen) {
            root.requestFullscreen().catch(() => null);
        } else if (!on && document.fullscreenElement === root) {
            document.exitFullscreen().catch(() => null);
        }
        setFullscreen(on);
    });
    document.addEventListener('fullscreenchange', () => {
        if (!document.fullscreenElement && root.classList.contains('alg-fullscreen')) {
            setFullscreen(false);
        }
    });
    root.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && root.classList.contains('alg-fullscreen') && !document.fullscreenElement) {
            setFullscreen(false);
        }
    });
    return {root, bar, button};
};
