# Algorithm Question Type for Moodle Quizzes

[![Moodle Plugin CI](https://github.com/blagojevicboban/moodle-qtype_algorithm/actions/workflows/ci.yml/badge.svg)](https://github.com/blagojevicboban/moodle-qtype_algorithm/actions/workflows/ci.yml)
[![Moodle](https://img.shields.io/badge/Moodle-4.5%20to%205.3-orange.svg)](https://moodle.org)
[![PHP](https://img.shields.io/badge/PHP-8.2%2B-purple.svg)](https://php.net)
[![License](https://img.shields.io/badge/License-GPL%20v3-blue.svg)](LICENSE)

**Algorithm** is a Moodle question type for quizzes in which the **student draws an algorithm as a flowchart** and can run it
before submitting. It uses the flowchart editor of
[tiny_algorithm](https://github.com/blagojevicboban/moodle-tiny_algorithm). The answer is graded manually.

> Status: **alpha**.

## ✨ Features

| Feature | Description |
|---------|-------------|
| ✏️ **Draw the Algorithm** | The same editor as in TinyMCE: all block types, several functions, undo / redo |
| ▶️ **Run Before Submitting** | Run / Step with a console, variable watch and generated code (Python, C, Java, C#) |
| 🧑‍🏫 **Runnable Review** | In the review and on the manual grading page the teacher can run and step through the submitted diagram |
| 📝 **Manual Grading** | Uses Moodle's manual grading behaviour |
| 💾 **Autosave** | The answer is saved with the normal quiz autosave |
| ✅ **Completeness Check** | An empty diagram counts as no answer |
| 🖼️ **Diagrams in the Question Text** | Give students an algorithm to analyse (needs [filter_algorithm](https://github.com/blagojevicboban/moodle-filter_algorithm)) |
| 🌐 **Languages** | English, Serbian Latin and Serbian Cyrillic |
| 🔒 **Privacy** | GDPR compliant (Privacy API; answers are stored by the question engine) |

## 📋 Requirements

- **Moodle**: 4.5 LTS or newer (4.5 and 5.3 tested; 5.0 – 5.2 declared compatible)
- **PHP**: 8.2+
- **[tiny_algorithm](https://github.com/blagojevicboban/moodle-tiny_algorithm)**: must be installed first (its `editor`, `runner`
  and `model` modules are used)
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

1.  **Create the question**: in a quiz or question bank choose **Add a question → Algorithm**.
2.  **Write the task** in the question text and save. A diagram inserted with **Interactive** in the text lets students analyse a
    given algorithm.
3.  **Grade**: after the attempt, open **Results → Manual grading** (or the quiz review). The submitted diagram can be run, stepped
    through and shown as generated code.

### For Students

1.  Draw the algorithm in the editor inside the question: click a **+** to add blocks, click a block to edit it.
2.  Test it with **Run** or **Step**, then submit the quiz as usual.

## 🛠️ Development

```bash
# Rebuild the AMD module after changing amd/src (from the Moodle root)
npx grunt amd --root=public/question/type/algorithm
```

## 📁 Structure

```
question/type/algorithm/
├── amd/
│   ├── src/          # attempt.js
│   └── build/        # Compiled module
├── classes/          # privacy provider
├── lang/             # en, sr_lt, sr_cr
├── edit_algorithm_form.php
├── question.php
├── questiontype.php
├── renderer.php
└── version.php       # Plugin metadata
```

## ⚠️ Known Limitations

- Grading is manual; automatic grading by test inputs is not implemented.
- The question type has no options of its own (for example a starter diagram), so there is nothing to back up or import / export.
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
