# Algorithm Question Type (Moodle Quiz)

**Algorithm** is a Moodle question type for quizzes in which the **student draws an algorithm as a flowchart** and can run it
before submitting. It uses the flowchart editor of
[tiny_algorithm](https://github.com/blagojevicboban/moodle-tiny_algorithm). The answer is graded manually.

> Status: **alpha**. Tested on Moodle 5.3 (one attempt with the admin user, immediate feedback behaviour).

## Features

- **Student draws the algorithm** with the same editor as in TinyMCE: blocks for declare, assign, input, output, if, for, while,
  do…while, call, return and comment, several functions, undo / redo, **Run / Step** with a console, variable watch and
  generated code (Python, C, Java, C#).
- **Manual grading**: the question uses Moodle's manual grading behaviour. In the review and in the grading page the teacher sees
  the submitted diagram and can **run it, step through it** and look at the generated code.
- **Autosave**: the answer is kept in a hidden field and saved with the normal quiz autosave.
- **Completeness check**: an empty diagram counts as no answer.
- **Interactive diagrams in the question text**: put a diagram (inserted with the **Interactive** option) in the question text
  to give students an algorithm to analyse. This needs the filter
  [filter_algorithm](https://github.com/blagojevicboban/moodle-filter_algorithm).
- **Languages**: English and Serbian (Latin).
- **Privacy Compliant**: Implements the Moodle Privacy API (null provider – answers are stored by the question engine).

## Related Plugins

- **[tiny_algorithm](https://github.com/blagojevicboban/moodle-tiny_algorithm)** – the flowchart editor. **Required**: this
  question type imports its `editor`, `runner` and `model` modules.
- **[filter_algorithm](https://github.com/blagojevicboban/moodle-filter_algorithm)** – Run / Step for diagrams in text (optional).

## Compatibility

| Moodle Version   | Status                                  |
|------------------|-----------------------------------------|
| Moodle 5.3       | ✅ Tested                               |
| Moodle 5.0 – 5.2 | ⚠️ Declared minimum is 5.0, not tested |
| Moodle 4.x       | ❌ Not supported (requires Moodle 5.0+) |

## Installation

1. Install **tiny_algorithm** first.
2. Place this plugin folder in `question/type/algorithm` (Moodle 5.0) or `public/question/type/algorithm` (Moodle 5.1 and later).
3. Log in as an administrator and go to **Site administration → Notifications** to complete the installation.

## Usage

1. In a quiz or question bank choose **Add a question → Algorithm**.
2. Write the task in the question text and save.
3. Students draw and test their algorithm in the question. After the attempt is finished, grade it under **Results → Manual
   grading** (or the quiz review).

## Known Limitations

- Grading is manual. Automatic grading by test inputs is not implemented.
- The question type has no options of its own (for example a starter diagram), and no backup / restore or import / export
  support for options (there are none to save).
- The editor inside the quiz also offers the generated code and Import / Export of `.fprg` files.

## Technical Requirements

- Moodle 5.0 or higher (5.3 tested)
- [tiny_algorithm](https://github.com/blagojevicboban/moodle-tiny_algorithm) installed
- Node.js 20+ (only for building AMD modules if you modify the source)

## Building from Source

```bash
npx grunt amd --root=public/question/type/algorithm
```

## Changelog

See [CHANGELOG.md](CHANGELOG.md) for version history.

## License

This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as
published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

See [LICENSE](LICENSE) for details.

---

© 2026 [Boban Blagojević](https://github.com/blagojevicboban)
