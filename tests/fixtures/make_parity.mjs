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

// Matrices: both index forms, input into an element, String and Real matrices, the errors and the size limit.
const mx = (name, varType, size, size2) => B('declare', {name, varType, size, size2});
cases.push(['matrix', prog(dek('i'), dek('j'), dek('n'), B('input', {target: 'n'}), mx('a', 'Integer', 'n', 'n + 1'),
    mx('w', 'String', '2', '2'), mx('r', 'Real', '2', '3'),
    B('for', {variable: 'i', start: '0', end: 'n - 1', step: '1', body: [
        B('for', {variable: 'j', start: '0', end: 'n', step: '1', body: [B('assign', {target: 'a[i, j]', expr: 'i * 10 + j'})]})]}),
    B('assign', {target: 'a[1][2]', expr: 'a[1, 2] / 4'}), B('input', {target: 'a[0, n]'}),
    B('assign', {target: 'w[1, 0]', expr: '"x" & a[0][n]'}), B('assign', {target: 'r[1, 2]', expr: '7 / 2'}),
    ...outs('a[1, 2] & " " & a[0, n] & " " & Len(a)', 'w[1, 0] & "|" & w[0, 1] & "|"', 'r[1, 2] + r[0, 0]')),
['3\n9', '2\n4.7', '1\n5']]);
cases.push(['matrix one index', prog(mx('m', 'Integer', '2', '3'), out('m[1]'))]);
cases.push(['array two indexes', prog(dek('a', 'Integer', '3'), out('a[1, 1]'))]);
cases.push(['matrix row range', prog(mx('m', 'Integer', '2', '3'), out('m[2, 0]'))]);
cases.push(['matrix column range', prog(mx('m', 'Integer', '2', '3'), out('m[1][3]'))]);
cases.push(['matrix fraction index', prog(mx('m', 'Integer', '2', '3'), out('m[0.5, 1]'))]);
cases.push(['matrix size limit', prog(mx('m', 'Integer', '100', '1000'), out('Len(m)'), mx('b', 'Integer', '317', '316'))]);
cases.push(['matrix second size only', prog(mx('e', 'Integer', '', '4'), out('e'))]);

// Matrices as parameters: changed by a function (passed by reference), read by another, and the wrong shapes.
const mparam = (body) => {
    const p = prog(mx('a', 'Integer', '2', '3'), dek('v', 'Integer', '3'), ...body);
    const m = {name: 'm', type: 'Integer', array: true, matrix: true};
    p.functions.push({name: 'Set', params: [m], returnType: '', body: [B('assign', {target: 'm[1, 2]', expr: '7'})]},
        {name: 'Get', params: [m, {name: 'i', type: 'Integer'}], returnType: 'Integer',
            body: [B('return', {expr: 'm[i][2] + 1'})]},
        {name: 'Row', params: [{name: 'r', type: 'Integer', array: true}], returnType: '', body: []});
    return p;
};
cases.push(['matrix parameter', mparam([B('call', {expr: 'Set(a)'}), out('a[1, 2] & " " & Get(a, 1) & " " & Get(a, 0)')])]);
cases.push(['array for a matrix parameter', mparam([B('call', {expr: 'Set(v)'})])]);
cases.push(['matrix for an array parameter', mparam([B('call', {expr: 'Row(a)'})])]);
cases.push(['number for a matrix parameter', mparam([B('call', {expr: 'Set(5)'})])]);
cases.push(['matrix parameter one index', mparam([B('call', {expr: 'Get(a, 5)'})])]);

// 2.4: names that are properties of JavaScript objects, the limits, strict input, seeded Random, Pi, Flowgorithm
// functions, Break and Continue.
cases.push(['object names', prog(dek('constructor'), dek('__proto__'), dek('toString', 'String'),
    B('assign', {target: 'constructor', expr: '5'}), B('assign', {target: '__proto__', expr: 'constructor * 2'}),
    B('assign', {target: 'toString', expr: '"x"'}), out('constructor & " " & __proto__ & " " & toString'))]);
cases.push(['undeclared constructor', prog(out('constructor'))]);
cases.push(['call constructor', prog(out('constructor(1)'))]);
cases.push(['call hasOwnProperty', prog(out('hasOwnProperty(1)'))]);
const deep = (n) => {
    const p = prog(out(`Down(${n})`));
    p.functions.push({name: 'Down', params: [{name: 'n', type: 'Integer'}], returnType: 'Integer', body: [
        B('while', {cond: 'true', body: [
            B('if', {cond: 'n <= 1', then: [B('return', {expr: '1'})], 'else': [
                B('for', {variable: 'k', start: '1', end: '1', step: '1', body: [B('return', {expr: 'Down(n - 1) + 1'})]})]})]})]});
    return p;
};
cases.push(['recursion 199', deep(199)], ['recursion 200', deep(200)], ['recursion 201', deep(201)]);
cases.push(['endless recursion', (() => {
    const p = prog(B('call', {expr: 'Again()'}));
    p.functions.push({name: 'Again', params: [], returnType: '', body: [B('call', {expr: 'Again()'})]});
    return p;
})()]);
cases.push(['output limit', prog(B('for', {variable: 'i', start: '1', end: '20000', step: '1',
    body: [out('"0123456789"', false)]}))]);
cases.push(['output just below the limit', prog(B('for', {variable: 'i', start: '1', end: '10000', step: '1',
    body: [out('"0123456789"', false)]}))]);
const inputCase = (type) => prog(dek('v', type), B('input', {target: 'v'}), out('v'));
for (const type of ['Integer', 'Real', 'Boolean', 'String']) {
    cases.push([`strict input ${type}`, inputCase(type), ['3', ' 3 ', '+5', '-7', '3.7', '0x10', '1e3', '-.5', '5.',
        'Infinity', '""', '3,5', 'TRUE', 'false', 'yes', '1', ' ', '12abc']]);
}
cases.push(['random with seed', prog(dek('i'), B('for', {variable: 'i', start: '1', end: '20', step: '1',
    body: [out('Random(10)', false), out('" "', false)]}), out('Random(1000000)'), out('Random(0)'), out('Random(2.5)'))]);
cases.push(['pi', prog(out('pi'), out('Pi * 2'), out('Pi()'), dek('pi', 'Real'), B('assign', {target: 'pi', expr: '3'}),
    out('pi'), out('Pi()'))]);
cases.push(['flowgorithm functions', prog(...outs('ToInteger("12")', 'ToInteger(3.9)', 'Sgn(-4)', 'Sgn(0)', 'Size("abc")',
    'Arcsin(1)', 'Arccos(0)', 'Arctan(1)', 'Log10(1000)', 'Log10(2)', 'ToFixed(3.14159, 2)', 'ToFixed(2.5, 0)',
    'ToFixed(-2.5, 0)', 'ToFixed(1.005, 2)', 'ToFixed(-0.001, 2)', 'ToFixed(7, 3)', 'ToFixed(10 ^ 21, 2)',
    'ToFixed(123.456, -1)', 'ToFixed(1, 25)', 'ToFixed("2.25", 1)', 'ToFixed(0.1 + 0.2, 1)'))]);
cases.push(['size of an array', prog(dek('a', 'Integer', '4'), out('Size(a)'))]);
const loopsWith = (kind) => prog(dek('s'), dek('i'), dek('j'),
    B('for', {variable: 'i', start: '1', end: '10', step: '1', body: [
        B('if', {cond: 'i mod 3 = 0', then: [B(kind)], 'else': []}), out('i', false), out('" "', false)]}), out('""'),
    B('assign', {target: 'i', expr: '0'}),
    B('while', {cond: 'i < 10', body: [B('assign', {target: 'i', expr: 'i + 1'}),
        B('if', {cond: 'i mod 4 = 0', then: [B(kind)], 'else': []}), out('i', false), out('","', false)]}), out('""'),
    B('assign', {target: 'i', expr: '0'}),
    B('dowhile', {cond: 'i < 7', body: [B('assign', {target: 'i', expr: 'i + 1'}),
        B('if', {cond: 'i = 2', then: [B(kind)], 'else': []}), out('i', false), out('";"', false)]}), out('""'),
    B('for', {variable: 'i', start: '1', end: '3', step: '1', body: [
        B('for', {variable: 'j', start: '1', end: '3', step: '1', body: [
            B('if', {cond: 'j = 2', then: [B(kind)], 'else': []}), out('i * 10 + j', false), out('" "', false)]})]}),
    out('"end " & i & " " & j'));
cases.push(['break', loopsWith('break')], ['continue', loopsWith('continue')]);
cases.push(['break outside a loop', prog(out('"x"'), B('break'))]);
cases.push(['continue in an if outside a loop', prog(B('if', {cond: 'true', then: [B('continue')], 'else': []}))]);
cases.push(['break in a function called from a loop', (() => {
    const p = prog(B('for', {variable: 'i', start: '1', end: '2', step: '1', body: [B('call', {expr: 'F()'})]}));
    p.functions.push({name: 'F', params: [], returnType: '', body: [B('break')]});
    return p;
})()]);
cases.push(['return from inside a loop', (() => {
    const p = prog(out('Find(7)'));
    p.functions.push({name: 'Find', params: [{name: 'x', type: 'Integer'}], returnType: 'Integer', body: [
        B('for', {variable: 'i', start: '1', end: '100', step: '1', body: [
            B('if', {cond: 'i * i > x', then: [B('return', {expr: 'i'})], 'else': [B('continue')]})]}),
        B('return', {expr: '-1'})]});
    return p;
})()]);

// 2.5.3: strings and arrays cannot fill the memory of the grading server.
const grow = (piece, times) => [dek('s', 'String'), dek('i'),
    B('for', {variable: 'i', start: '1', end: String(times), step: '1', body: [B('assign', {target: 's', expr: `s & "${piece}"`})]}),
    out('Len(s)')];
cases.push(['string doubling', prog(dek('s', 'String'), B('assign', {target: 's', expr: '"x"'}),
    B('while', {cond: 'true', body: [B('assign', {target: 's', expr: 's & s'}), out('Len(s)')]}))]);
cases.push(['string at the limit', prog(...grow('0123456789', 10000), out('Len(s + "")'), out('Len(s + "x")'))]);
cases.push(['string limit with &', prog(...grow('0123456789', 10000), out('Len(s & "x")'))]);
cases.push(['string of two-byte letters', prog(...grow('жжжжжжжжжж', 6000))]);
cases.push(['string of emoji over the limit', prog(...grow('😀😀😀😀😀', 10001))]);
cases.push(['string of emoji at the limit', prog(...grow('😀😀😀😀😀', 10000))]);
cases.push(['arrays in a recursion', (() => {
    const p = prog(B('call', {expr: 'F(1)'}));
    p.functions.push({name: 'F', params: [{name: 'n', type: 'Integer'}], returnType: '', body: [
        dek('a', 'Integer', '100000'), out('n'), B('call', {expr: 'F(n + 1)'})]});
    return p;
})()]);
cases.push(['arrays freed after each call', (() => {
    const p = prog(dek('i'), B('for', {variable: 'i', start: '1', end: '30', step: '1', body: [B('call', {expr: 'G()'})]}),
        out('"done"'));
    p.functions.push({name: 'G', params: [], returnType: '', body: [dek('a', 'Integer', '100000')]});
    return p;
})()]);
cases.push(['array declared again in a loop', prog(B('while', {cond: 'true', body: [dek('a', 'Integer', '100000')]}))]);
cases.push(['array replaced by a value', prog(dek('k'), B('for', {variable: 'k', start: '1', end: '30', step: '1', body: [
    dek('b', 'Integer', '100000'), dek('b')]}), out('"done " & b'))]);
cases.push(['ten names at the memory limit', prog(dek('a, b, c, d, e, f, g, h, p, q', 'Integer', '100000'), out('Len(q)'),
    dek('z', 'Integer', '1'), out('"not reached"'))]);
cases.push(['matrix with no columns', prog(mx('m', 'Integer', '100000000', '0'), out('Len(m)'))]);
cases.push(['matrix with no columns at the limit', prog(mx('m', 'Integer', '100000', '0'), out('Len(m)'))]);

// Function tests with arrays and matrices written in the call.
const arr = createProgram();
arr.functions[0].body = [out('"main"')];
const ap = (name, type = 'Integer', matrix = false) => ({name, type, array: true, matrix});
arr.functions.push(
    {name: 'Sum', params: [ap('a')], returnType: 'Integer', body: [dek('s'),
        B('for', {variable: 'i', start: '0', end: 'Len(a) - 1', step: '1', body: [B('assign', {target: 's', expr: 's + a[i]'})]}),
        B('return', {expr: 's'})]},
    {name: 'Sort', params: [ap('a')], returnType: '', body: [dek('t'),
        B('for', {variable: 'i', start: '0', end: 'Len(a) - 2', step: '1', body: [
            B('for', {variable: 'j', start: '0', end: 'Len(a) - 2 - i', step: '1', body: [
                B('if', {cond: 'a[j] > a[j + 1]', then: [B('assign', {target: 't', expr: 'a[j]'}),
                    B('assign', {target: 'a[j]', expr: 'a[j + 1]'}), B('assign', {target: 'a[j + 1]', expr: 't'})], 'else': []})]})]})]},
    {name: 'Trace', params: [ap('m', 'Real', true)], returnType: 'Real', body: [dek('s', 'Real'),
        B('for', {variable: 'i', start: '0', end: 'Len(m) - 1', step: '1', body: [B('assign', {target: 's', expr: 's + m[i, i]'})]}),
        B('return', {expr: 's'})]},
    {name: 'Join', params: [ap('w', 'String'), {name: 'sep', type: 'String'}], returnType: 'String', body: [dek('r', 'String'),
        B('for', {variable: 'i', start: '0', end: 'Len(w) - 1', step: '1', body: [B('assign', {target: 'r', expr: 'r & w[i] & sep'})]}),
        B('return', {expr: 'r'})]},
    {name: 'Twice', params: [{name: 'x', type: 'Integer'}], returnType: 'Integer', body: [B('return', {expr: 'x * 2'})]},
);
const arrayCalls = ['Sum([1, 2, 3])', 'Sum([])', 'Sum([1.9, -2.5])', 'Sum(["4", 5])', 'Sum([1, "x"])', 'Sum([[1], [2]])',
    'Sum(5)', 'Sort([3, 1, 2])', 'Sort([5, -1, 5, 0])', 'Trace([[1, 2], [3, 4]])', 'Trace([[1.5]])', 'Trace([[1, 2], [3]])',
    'Trace([1, 2])', 'Trace([])', 'Join(["a", "b"], "-")', 'Join([1, true], "")', 'Twice([1])', 'Twice(3) + Sum([1, 2])',
    'Sum([1, 2', 'Sum([1 2])'];

// Function tests: the call and the value it returns (the functions of the 'functions' case).
const calls = ['Fact(5)', 'Fib(10)', 'Half(7)', 'NoReturn()', 'Fact("3")', 'Two(1)', 'Fact(n)', 'Half(1, 2)', 'Missing(1)',
    'Fact(2 + 1) & "!"', 'Fill(3, 4)'];

const extra = process.argv[3] ? JSON.parse(readFileSync(process.argv[3], 'utf8')) : [];
const all = extra.length ? extra : [...cases.map(([name, program, inputs = ['']]) => ({name, program, inputs})),
    ...calls.map((call) => ({name: `call ${call}`, program: fn, inputs: [''], call})),
    ...arrayCalls.map((call) => ({name: `call ${call}`, program: arr, inputs: [''], call}))];
const fixtures = [];
for (const {name, program, inputs, call = null} of all) {
    for (const input of inputs) {
        const r = runProgram(program, input, 'en', call);
        fixtures.push({name, program, inputs: input, call, output: r.output, after: r.after, error: r.error, result: r.result});
    }
}
const target = process.argv[3] ? process.argv[3].replace(/\.json$/, '') + '-parity.json' : join(here, 'parity.json');
writeFileSync(target, JSON.stringify(fixtures, null, 1) + '\n');
console.log(`${fixtures.length} runs -> ${target}`);
