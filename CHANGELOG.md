# Changelog

## 1.1.0 – 2026-11-01 (stable)

- **Translated error messages:** `algorithm_error` has a code and values; `localized()` gives the message in the user's
  language from the `ui_e_*` strings of tiny_algorithm, so the test results of the review are translated too. The English
  message is unchanged and the parity check still compares it with the browser.
- **Limits:** an answer may have at most 2000 blocks (`MAX_BLOCKS`), 500000 characters and a JSON depth of 64; a larger
  answer is not complete and the student sees why (new string `toolarge`). Arrays are limited to 100000 elements
  (`interpreter::MAX_ARRAY_SIZE`, before 10 million) in both interpreters.
- **Fixed:** opening a question with a starting template filled in the answer, so the question counted as answered without
  any change; a saved answer could also be sent again as changed when the page loaded. The first drawing of the editor is
  no longer reported as a change.
- Enter in a field of the editor no longer submits the quiz page (tiny_algorithm 1.1.0); the question can be answered with
  the keyboard only.
- PHPUnit tests: question (decoding, completeness, limits, grading, required structures), question type (computed tests,
  Moodle XML round trip) and tester (output, localized errors). New parity fixtures for the array limit.
- `privacy:metadata` mentions the display settings in the browser's local storage. Screenshots in `docs/screenshots/`.
- Serbian translations are ekavian (rešenje, vrednost, posle, ocena).
- Requires `tiny_algorithm` 1.1.0 (2026110100).

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
