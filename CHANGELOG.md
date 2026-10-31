# Changelog

## 1.0.0 – 2026-10-31 (stable)

- **Stable release.**
- The attempt, review and question form load the widget texts from the language files of tiny_algorithm before they build
  the editor, so they follow the user's language and can be translated in AMOS; the generated code is also available in
  C++, JavaScript and Pascal.
- `tests/fixtures/make_parity.mjs` has the Moodle GPL boilerplate.
- Requires `tiny_algorithm` 1.0.0 (2026103100).

## 0.3.0 – 2026-10-28 (alpha)

- **Automatic grading with tests.** The teacher draws the solution and enters test inputs; the expected outputs are computed
  from the solution when the question is saved. The answer runs on the server (new PHP interpreter in `classes/local`, the same
  rules and output as the browser interpreter of tiny_algorithm, checked with `tests/fixtures`). Grade: share of passed tests or
  all or nothing. Questions without tests are still graded manually.
- What is compared: the whole output or only the output after the last input, optionally only the numbers in it.
- **Hidden tests**, **required structures** (If, For, While, Do, array), **starting template**, students can run the visible
  tests during the attempt, feedback per test, the teacher's solution in the review.
- Toolbar above the editor: **Test** and **Full screen** in the quiz; **Full screen** for the solution and template editors in
  the question form (new `fullscreen` module).
- New table `qtype_algorithm_options` (questions from 0.2.0 get a row without tests), backup / restore, Moodle XML import / export.
- Requires tiny_algorithm 0.5.2.

## 0.2.0 – 2026-10-16 (alpha)

- Supports **Moodle 4.5 LTS** (`requires` lowered to 4.5, `supported` 4.5 – 5.3); tested on 4.5, 5.0 – 5.3.
- Moodle coding standard: phpcs, ESLint and stylelint report no problems; GitHub Actions (moodle-plugin-ci) added.
- New README and `description.html` for the Moodle plugins directory.
- **Serbian Cyrillic (sr_cr)** language files and UI strings; the UI picks Latin or Cyrillic from the Moodle language.

## 0.1.0 – 2026-10-17 (alpha)

- First version: a quiz question type in which the student draws an algorithm with the `tiny_algorithm` editor; manual grading with a
  runnable review.
