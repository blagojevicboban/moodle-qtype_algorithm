# Changelog

## 2.14.0 – 2026-11-11 (stable)

- **Parsons problems:** a new option of the question, Parsons problem. Students do not draw the algorithm: they get
  every block of the solution in a random order, with loops and branches empty, and move the blocks to their places
  and into loops and branches (the editor of tiny_algorithm 2.14 in its Parsons mode: no new blocks, no changes of the
  text). The answer is graded with the tests like any other.
- **Extra wrong blocks** (0 to 5): copies of blocks of the solution with a small mistake (< instead of <=, - 1 instead
  of + 1, or instead of and, a number one bigger), which students must delete.
- The order is chosen when the attempt starts and kept in the attempt (the same student sees the same problem after a
  reload); the order of the solution never reaches the browser.
- New class local/parsons, fields parsons and distractors (upgrade step 2026111506, backup and restore, XML export and
  import), PHPUnit tests; new strings in English, Serbian Latin and Serbian Cyrillic.
- Version number 2.14.0, the same as tiny_algorithm; requires tiny_algorithm 2.14.0 (2026111513).

## 2.9.0 – 2026-11-10 (stable)

- **Files in questions:** the PHP interpreter runs Open, Read, Write, Close and EOF() of tiny_algorithm 2.9.0 like the
  browser. The tests read the files of the question (attached to the solution), not files a student changed in the
  answer; the files are part of the cache key of the results.
- 13 new parity cases (210 runs, PHP = JavaScript) and a PHPUnit test of grading with files.
- Requires tiny_algorithm 2.9.0 (2026111508).

## 2.8.0 – 2026-11-10 (stable)

- **Code language:** the attempt, the review and the solution show the language chosen with the solution of the
  question, else the language of the course or the site; Students see only this language in the solution editor locks
  it. A course that forces its language comes first. The question form starts in the language of the course or site.
- Requires tiny_algorithm 2.8.0 (2026111507).

## 2.7.0 – 2026-11-10 (stable)

- **Turtle graphics in questions:** the PHP interpreter runs the new turtle blocks of tiny_algorithm 2.7.0 (Forward,
  Turn, Pen, Home, Clear) with the same checks and steps as the browser, so a response that draws is graded on its
  output like any other; the drawing itself is shown in the browser.
- 7 new parity cases (197 runs, PHP = JavaScript).
- Version number 2.7.0, the same as tiny_algorithm; requires tiny_algorithm 2.7.0 (2026111505).

## 2.5.3 – 2026-11-09 (stable)

- **Grading cannot be stopped by a response:** the PHP interpreter limits strings to 100,000 characters and the arrays
  of the running calls to 1,000,000 elements, and declaring an array costs steps. Before, a three-block algorithm that
  doubled a string in a loop, or a recursion that declared a big array in every call, ended the grading with a PHP
  fatal error, so the attempt could not be submitted and its review could not be opened.
- **Test results are cached:** the review of an attempt reuses the results of the grading instead of running every
  test again on each view (Moodle cache qtype_algorithm/results).
- A response is decoded once per request.
- New parity cases for the limits; the PHP and JavaScript interpreters give the same results in all 190 runs.
- Version number 2.5.3, the same as tiny_algorithm. Requires tiny_algorithm 2.5.3 (2026111503).

## 2.5.1 – 2026-11-08 (stable)

- Requires tiny_algorithm 2.5.1 (2026111501).

## 2.5.0 – 2026-11-08 (stable)

- **Synchronized 2.5.0 release:** unified versioning and build alignment with tiny_algorithm and filter_algorithm (build 2026111500).
- **Dependencies update:** requires tiny_algorithm 2.5.0 (2026111500).
- **Maintenance & QA:** rebuilt AMD modules with Moodle Grunt, validated copyright headers across all files.

## 2.4.1 – 2026-11-05 (stable)

- **Default code language:** the language chosen in the code panel of the solution or the template in the question
  form is the one students see first in the attempt (needs tiny_algorithm 2.4.1). A student's choice does not change
  the answer.
- With tiny_algorithm 2.4.1: the code in its own column in full screen, menus that are never cut off.

## 2.4.0 – 2026-11-05 (stable)

- **Interpreter as in tiny_algorithm 2.4** (parity.json: 177 runs, 0 different): Break and Continue, at most 200 nested
  calls and 100000 characters of output, typed input (3.7 is not an Integer), Random from a seed in every test and
  grading run, Pi, Flowgorithm's ToInteger, Sgn, Size, Arcsin, Arccos, Arctan, Log10 and ToFixed, safe names.
- **Function tests with arrays and matrices:** `Sort([3, 1, 2])` or `Trace([[1, 2], [3, 4]])`; the result also shows
  the arrays after the call, so procedures that change an array can be graded.
- **Hide the code and the file tools:** a new option (Student editor) removes the code panel, the `.fprg` import and
  export and the picture buttons from the editor of the attempt. Stored in backups and Moodle XML.
- **Upgrade step 2026111000:** adds the option and computes the expected outputs of all tests again from the solutions;
  questions whose solution now fails a test are listed.
- **Step with a failed test:** the student can step through the algorithm with the input of a failed visible test.
- **Accessibility:** the editor is in a fieldset with a legend for screen readers and is described by the rules.
- With tiny_algorithm 2.4: breakpoints, the call stack, the trace table, pseudo-code and eleven languages,
  Break and Continue blocks, comments on blocks.

## 2.2.1 – 2026-11-05 (stable)

- **Run and Step are not an answer:** the editor draws again during Run and Step, and the attempt took that for a
  change. Stepping through the template saved it as the answer and the test results were marked as old after every
  step. Now only a real change of the algorithm answers the question or makes the results old (`attempt.js`).
- **Screenshots:** new pictures of the attempt, the interactive behaviour and the edit form.

## 2.2.0 – 2026-11-05 (stable)

- **Matrices as parameters:** the PHP interpreter (automatic grading) accepts matrix parameters like the editor of
  tiny_algorithm (`m: Integer[,]`), passed by reference, with the same errors for an argument of the wrong shape.
  New parity cases in `tests/fixtures/make_parity.mjs`.

## 2.0.0 – 2026-11-02 (stable)

- **Weights:** a test has a `weight` (1 by default); the grade is the share of the passed weight. The results table has a
  weight column when the weights differ.
- **Function tests:** a test with `call` calls one function of the algorithm with the inputs as arguments and compares the
  value it returns (`tester::call_text`, `interpreter::run($input, $call)`, `result()`), exactly as in the browser.
- **Comparison options:** `ignorecase`, `ignorespaces` and `tolerance` (new columns, upgrade step 2026110202, form, rules
  shown to the student, Moodle XML, backup).
- **Interactive behaviour with several tries:** hints and penalty in the form; hints are saved, exported and imported.
- **Response analysis:** `classify_response` and `get_possible_responses` give for every test passed, different output or
  error, so the quiz statistics show which tests fail most.
- Random questions may pick algorithm questions (`is_usable_by_random`).
- **Matrices** in the PHP interpreter (same as the browser, new error code `dimensions`) and the required structure
  `matrix`.
- Parity fixtures for matrices and function calls (60 runs); PHPUnit for weights, function tests, comparison,
  classify_response, XML with the new fields and a hint, matrices.
- Requires `tiny_algorithm` 2.0.0 (2026110203).

## 1.2.0 – 2026-11-02 (stable)

- With tiny_algorithm 1.2.0: renaming a function in the answer also renames its calls.
- CSS classes renamed from `alg-*` to `tiny_algorithm-*` (full screen workspace).
- Requires `tiny_algorithm` 1.2.0 (2026110201).

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
- The `structures` column of `qtype_algorithm_options` may be null (upgrade step 2026110200): XMLDB does not allow a
  NOT NULL text column with an empty default, which stopped the PHPUnit installation in CI.
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
