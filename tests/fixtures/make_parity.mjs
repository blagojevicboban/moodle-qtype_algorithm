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
 * Builds parity.json: algorithms with inputs and what the browser interpreter (tiny_algorithm) gives for them.
 * The PHP interpreter must give exactly the same (tests/interpreter_test.php).
 *
 * node --import <tiny>/tests/register.mjs tests/fixtures/make_parity.mjs [<tiny dir>] [extra.json]
 *   extra.json: optional [{name, program, inputs: [..]}] run instead (e.g. a course's algorithms); writes extra-parity.json
 *
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
import {readFileSync, writeFileSync} from 'node:fs';
import {dirname, join, resolve} from 'node:path';
import {fileURLToPath, pathToFileURL} from 'node:url';

const here = dirname(fileURLToPath(import.meta.url));
const tiny = resolve(process.argv[2] || join(here, '../../../moodle-tiny_algorithm'));
const {createProgram, createBlock: B} = await import(pathToFileURL(join(tiny, 'amd/src/model.js')).href);
const {runProgram} = await import(pathToFileURL(join(tiny, 'amd/src/tests.js')).href);

const prog = (...body) => {
    const p = createProgram();
    p.functions[0].body = body;
    return p;
};
const dek = (name, varType = 'Integer', size = '') => B('declare', {name, varType, size});
const out = (expr, newline = true) => B('output', {expr, newline});
const outs = (...exprs) => exprs.map((e) => out(e));

const cases = [
    ['numbers', prog(...outs('7 / 2', '1 / 3', '2 / 3 * 3', '0.1 + 0.2', '10 ^ 21', '10 ^ 20', '0.000001', '0.0000001',
        '-0.5', '2 ^ 0.5', '-7 / 2', '7 mod 3', '-7 mod 3', '7.5 mod 2', '2 ^ 60', '1 / 0.0001', '123456789 * 1000000',
        '0.1 * 3', '100 / 3', 'Round(2.5)', 'Round(-2.5)', 'Int(-3.7)', 'Floor(-3.2)', 'Ceiling(3.2)', 'Abs(-4)',
        'Sqrt(2)', 'Sqrt(-1)', 'Sign(-3)', 'Log(10)', 'Exp(1)', 'Sin(Pi())', 'Cos(0)', '3 - -2', '- 2 ^ 2'))],
    ['strings', prog(...outs('"a" & 1 & true', '"5" + 3', '3 + "5"', '"b" < "a"', '"10" < "9"', '10 < 9', '"abc" = "abc"',
        '"Č" > "Z"', 'Len("čćž")', 'Len("")', 'Char("Ana", 2)', 'ToCode("Ш")', 'ToChar(382)', 'char(65)',
        'ToInt("12")', 'ToInt(" 7 ")', 'ToReal("2.5")', 'ToString(0.1 + 0.2)', 'IsNumeric("1e3")', 'IsNumeric("x")',
        'IsNumeric("")', '"x\\ty\\n" & "z"', '1 = 1.0', '"1" = 1', 'true = 1', 'not 0', 'not ""', 'not "0"',
        '"a" <> "b" and 3 > 2 or false', '0.1 + 0.2 = 0.3'))],
    ['types', prog(dek('i'), dek('r', 'Real'), dek('s', 'String'), dek('b', 'Boolean'),
        B('assign', {target: 'i', expr: '7 / 2'}), B('assign', {target: 'r', expr: '7 / 2'}),
        B('assign', {target: 's', expr: '7 / 3'}), B('assign', {target: 'b', expr: '3 > 2'}),
        ...outs('i', 'r', 's', 'b', 'i & r & s & b'), B('assign', {target: 'i', expr: '"12"'}), out('i + 1'),
        B('assign', {target: 'i', expr: '-2.9'}), out('i'), B('assign', {target: 's', expr: '0.1 + 0.2'}), out('s'))],
    ['exponent literal', prog(out('1e21'))],
    ['bad assign', prog(dek('i'), B('assign', {target: 'i', expr: '"abc"'}))],
    ['bool assign', prog(dek('b', 'Boolean'), B('assign', {target: 'b', expr: '1'}))],
    ['undeclared', prog(B('assign', {target: 'x', expr: '1'}))],
    ['division by zero', prog(out('"before"'), out('5 / 0'))],
    ['mod zero', prog(out('5 mod 0'))],
    ['syntax', prog(out('1 +'))],
    ['syntax 2', prog(out('(1 + 2'))],
    ['syntax 3', prog(out('"abc'))],
    ['syntax 4', prog(out('2 # 3'))],
    ['unknown function', prog(out('Foo(1)'))],
    ['char out of range', prog(out('Char("ab", 5)'))],
    ['tocode empty', prog(out('ToCode("")'))],
    ['endless', prog(dek('i'), B('while', {cond: 'true', body: [B('assign', {target: 'i', expr: 'i + 1'})]}))],
    ['for', prog(dek('s'), B('for', {variable: 'i', start: '1', end: '10', step: '3', body: [out('i', false), out('" "', false)]}),
        out('""'), B('for', {variable: 'i', start: '5', end: '1', step: '-2', body: [out('i')]}),
        B('for', {variable: 'j', start: '1', end: '0', step: '1', body: [out('"never"')]}),
        B('for', {variable: 'k', start: '0', end: '1', step: '0.25', body: [out('k')]}), out('i'))],
    ['for step zero', prog(B('for', {variable: 'i', start: '1', end: '3', step: '0', body: []}))],
    ['array size limit', prog(dek('a', 'Integer', '100000'), out('Len(a)'), dek('b', 'Integer', '100001'))],
    ['array size from text', prog(dek('a', 'Integer', '"abc"'), out('Len(a)'), dek('b', 'Real', '2.7'), out('Len(b)'))],
    ['arrays', prog(dek('a', 'Integer', '5'), dek('t', 'String', '2'),
        B('for', {variable: 'i', start: '0', end: '4', step: '1', body: [B('assign', {target: 'a[i]', expr: 'i * i'})]}),
        ...outs('a', 'a[4]', 'Len(a)', 't', 'Len(t)', 'a[1] + a[2]'), out('a[5]'))],
    ['array not array', prog(dek('x'), out('x[0]'))],
    ['input types', prog(dek('i'), dek('r', 'Real'), dek('s', 'String'), dek('b', 'Boolean'),
        ...['i', 'r', 's', 'b'].map((t) => B('input', {target: t})), ...outs('i', 'r', 's', 'b')), ['12.7\n-0.5\n  hi  \nTRUE',
        ' 5 \n1e2\n""\nx', '0x10\n.5\nč\ntrue']],
    ['bad input', prog(dek('i'), B('input', {target: 'i'})), ['abc', '', ' ']],
    ['input count', prog(dek('n'), dek('s'), out('"Koliko?"'), B('input', {target: 'n'}),
        B('for', {variable: 'i', start: '1', end: 'n', step: '1', body: [out('"Broj " & i & ":"'), B('input', {target: 'n'}),
            B('assign', {target: 's', expr: 's + n'})]}), out('"Zbir je " & s & ", prosek " & s / 3')),
    ['3\n1\n2\n4', '3\n1\n2', '2\n5\n5\n9', '1\n2']],
    ['after last input', prog(dek('a'), out('"x"'), B('input', {target: 'a'}), out('"y " & a', false), B('input', {target: 'a'}),
        out('"z " & a', false)), ['1\n2']],
];

// Functions, recursion, arrays passed to functions (shared), return values.
const fn = createProgram();
fn.functions[0].body = [dek('a', 'Integer', '3'), B('assign', {target: 'a[0]', expr: '5'}), B('call', {expr: 'Fill(a, 7)'}),
    out('a'), out('Fact(10)'), out('Fib(15)'), out('NoReturn()'), out('Half(7)')];
fn.functions.push(
    {name: 'Fill', params: [{name: 'x', type: 'Integer', array: true}, {name: 'v', type: 'Integer'}], returnType: '',
        body: [B('for', {variable: 'i', start: '1', end: 'Len(x) - 1', step: '1', body: [B('assign', {target: 'x[i]', expr: 'v'})]})]},
    {name: 'Fact', params: [{name: 'n', type: 'Integer'}], returnType: 'Integer',
        body: [B('if', {cond: 'n <= 1', then: [B('return', {expr: '1'})], 'else': [B('return', {expr: 'n * Fact(n - 1)'})]})]},
    {name: 'Fib', params: [{name: 'n', type: 'Integer'}], returnType: 'Integer',
        body: [B('if', {cond: 'n < 2', then: [B('return', {expr: 'n'})], 'else': []}), B('return', {expr: 'Fib(n - 1) + Fib(n - 2)'})]},
    {name: 'NoReturn', params: [], returnType: '', body: []},
    {name: 'Half', params: [{name: 'n', type: 'Integer'}], returnType: 'Real', body: [B('return', {expr: 'n / 2'})]},
);
cases.push(['functions', fn]);
const badcall = createProgram();
badcall.functions[0].body = [out('Two(1)')];
badcall.functions.push({name: 'Two', params: [{name: 'a', type: 'Integer'}, {name: 'b', type: 'Integer'}], body: []});
cases.push(['wrong argument count', badcall]);
const dw = prog(dek('n'), B('dowhile', {cond: 'n > 0', body: [B('input', {target: 'n'}), out('n * 2')]}));
cases.push(['do while', dw, ['3\n-1\n0', '0', '5']]);

const extra = process.argv[3] ? JSON.parse(readFileSync(process.argv[3], 'utf8')) : [];
const all = extra.length ? extra : cases.map(([name, program, inputs = ['']]) => ({name, program, inputs}));
const fixtures = [];
for (const {name, program, inputs} of all) {
    for (const input of inputs) {
        const r = runProgram(program, input, 'en');
        fixtures.push({name, program, inputs: input, output: r.output, after: r.after, error: r.error});
    }
}
const target = process.argv[3] ? process.argv[3].replace(/\.json$/, '') + '-parity.json' : join(here, 'parity.json');
writeFileSync(target, JSON.stringify(fixtures, null, 1) + '\n');
console.log(`${fixtures.length} runs -> ${target}`);
