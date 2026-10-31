# Algorithm Question Type for Moodle Quizzes

[![Moodle Plugin CI](https://github.com/blagojevicboban/moodle-qtype_algorithm/actions/workflows/ci.yml/badge.svg)](https://github.com/blagojevicboban/moodle-qtype_algorithm/actions/workflows/ci.yml)
[![Moodle](https://img.shields.io/badge/Moodle-4.5%20to%205.3-orange.svg)](https://moodle.org)
[![PHP](https://img.shields.io/badge/PHP-8.2%2B-purple.svg)](https://php.net)
[![License](https://img.shields.io/badge/License-GPL%20v3-blue.svg)](LICENSE)

**Algorithm** is a Moodle question type for quizzes in which the **student draws an algorithm as a flowchart** and can run it
before submitting. It uses the flowchart editor of
[tiny_algorithm](https://github.com/blagojevicboban/moodle-tiny_algorithm). With tests the answer is **graded automatically**:
the algorithm runs on the server on the inputs of every test and its output is compared with the output of the teacher's
solution. Without tests the teacher grades it manually.

> Status: **stable** (1.0).

## ✨ Features

| Feature | Description |
|---------|-------------|
| ✏️ **Draw the Algorithm** | The same editor as in TinyMCE: all block types, several functions, undo / redo |
| ▶️ **Run Before Submitting** | Run / Step with a console, variable watch and generated code (Python, C, C++, Java, C#, JavaScript, Pascal) |
| 🧑‍🏫 **Runnable Review** | In the review and on the manual grading page the teacher can run and step through the submitted diagram |
| ✅ **Automatic Grading** | Tests with inputs only; the expected outputs are computed from the teacher's solution. Grade = share of passed tests (or all or nothing) |
| 🔍 **Flexible Comparison** | Whole output, or only the output after the last input, and optionally only the numbers in it (students may write any text around them) |
| 🙈 **Hidden Tests** | Graded, but students see only whether they passed |
| 🧱 **Required Structures** | If, For, While, Do loop, array: an answer without them gets no marks |
| 🧪 **Test While Working** | Students run the visible tests in the browser; the server runs the same interpreter (PHP port, checked against the browser on every release) |
| ⛶ **Full Screen** | The editor (with the tests) can fill the screen, in the quiz and in the question form |
| 🧩 **Starting Template** | Students can start from a given diagram instead of an empty one |
| 🧑‍🏫 **Teacher's Solution in the Review** | Shown as a runnable diagram (“Right answer”) |
| 📝 **Manual Grading** | Questions without tests use Moodle's manual grading behaviour |
| 💾 **Autosave** | The answer is saved with the normal quiz autosave |
| ✅ **Completeness Check** | An empty diagram counts as no answer |
| 🖼️ **Diagrams in the Question Text** | Give students an algorithm to analyse (needs [filter_algorithm](https://github.com/blagojevicboban/moodle-filter_algorithm)) |
| 🌐 **Languages** | English, Serbian Latin and Serbian Cyrillic |
| 🔒 **Privacy** | GDPR compliant (Privacy API; answers are stored by the question engine) |

## 📋 Requirements

- **Moodle**: 4.5 LTS or newer (4.5, 5.0, 5.1, 5.2 and 5.3 tested)
- **PHP**: 8.2+
- **[tiny_algorithm](https://github.com/blagojevicboban/moodle-tiny_algorithm) 1.0.0+**: must be installed first (its `editor`,
  `runner`, `model` and `tests` modules are used)
- **[filter_algorithm](https://github.com/blagojevicboban/moodle-filter_algorithm)**: optional, for runnable diagrams in question text

## 🚀 Installation

### Via Git
```bash
cd /path/to/moodle/public/question/type          # Moodle 5.1+; use question/type in the Moodle root before 5.1
git clone https://github.com/blagojevicboban/moodle-qtype_algorithm.git algorithm
php admin/cli/upgrade.php
```

### Via Download
1. Install **tiny_algorithm** first
2. Download the [latest release](https://github.com/blagojevicboban/moodle-qtype_algorithm/releases)
3. Extract to `question/type/algorithm` (`public/question/type/algorithm` in Moodle 5.1+)
4. Visit Site Administration → Notifications

## 📖 Usage

### For Teachers

1.  **Create the question**: in a quiz or question bank choose **Add a question → Algorithm** and write the task.
2.  **Solution and tests**: draw the solution, add tests and type their inputs (one value per line, `""` for an empty value),
    tick **Hidden from students** where needed. Choose what is compared and which structures are required. The expected outputs
    are computed from the solution when you save; if the solution fails on a test, the form says so.
3.  **Starting template** (optional): tick *Students start from a separate template* and draw it.
4.  Without tests the question is graded manually: open **Results → Manual grading**; the diagram can be run and stepped through.

### For Students

1.  Draw the algorithm in the editor inside the question: click a **+** to add blocks, click a block to edit it.
2.  Test it with **Run** or **Step**, and with **Test** on the visible tests, then use **Check** or submit the quiz as usual.
    The feedback lists every test (hidden tests only as passed / failed).

## 🛠️ Development

```bash
# Rebuild the AMD modules after changing amd/src (from the Moodle root)
npx grunt amd --root=public/question/type/algorithm

# PHP interpreter = browser interpreter: regenerate the fixtures from tiny_algorithm and compare
node --import ../moodle-tiny_algorithm/tests/register.mjs tests/fixtures/make_parity.mjs ../moodle-tiny_algorithm
php tests/fixtures/check_parity.php
```

## 📁 Structure

```
question/type/algorithm/
├── amd/
│   ├── src/          # attempt.js (student), edit.js (question form)
│   └── build/        # Compiled modules
├── backup/moodle2/   # Backup and restore of the options
├── classes/local/    # PHP interpreter: expr, interpreter, tester, js (JavaScript value semantics)
├── classes/privacy/  # Privacy provider
├── db/               # qtype_algorithm_options, upgrade
├── tests/fixtures/   # Parity check: the PHP interpreter must give the browser's output
├── lang/             # en, sr_lt, sr_cr
├── edit_algorithm_form.php
├── question.php
├── questiontype.php
├── renderer.php
└── version.php       # Plugin metadata
```

## ⚠️ Known Limitations

- Interpreter error messages (e.g. *Division by zero*) are in English, as in the browser.
- Questions with tests are not offered to random questions, because questions without tests need manual grading.
- The editor inside the quiz also offers generated code and Import / Export of `.fprg` files.

## 🌍 Languages

- 🇬🇧 English
- 🇷🇸 Srpski (Serbian, Latin: sr_lt)
- 🇷🇸 Српски (Serbian, Cyrillic: sr_cr)

## 📝 Changelog

See [CHANGELOG.md](CHANGELOG.md).

## 📄 License

GNU GPL v3 or later - see [LICENSE](LICENSE).

## 👤 Author

**Boban Blagojević**  
[GitHub](https://github.com/blagojevicboban)

## 🙏 Credits

- [tiny_algorithm](https://github.com/blagojevicboban/moodle-tiny_algorithm) - the flowchart editor this question type builds on
- [Flowgorithm](https://www.flowgorithm.org/) - the flowchart style that inspired the project

---

Made with ❤️ for teaching programming
