<?php
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

namespace qtype_algorithm\local;

/**
 * Runs an algorithm on the server, step for step like the browser interpreter (tiny_algorithm/interpreter),
 * so that a grade computed here matches what the student sees with Run and Test.
 *
 * @package    qtype_algorithm
 * @copyright  2026 Boban Blagojević
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class interpreter {
    /** Largest array a Declare block may create (as MAX_ARRAY_SIZE in tiny_algorithm/interpreter). */
    const MAX_ARRAY_SIZE = 100000;

    /** @var array the algorithm model */
    protected array $program;

    /** @var array user functions by lower case name */
    protected array $funcs = [];

    /** @var array parsed expressions by source text */
    protected array $cache = [];

    /** @var int step limit */
    protected int $maxsteps;

    /** @var int steps so far */
    protected int $steps = 0;

    /** @var callable returns the next input value as text */
    protected $input;

    /** @var array output so far: [text, number of inputs read before it] */
    protected array $output = [];

    /** @var int inputs read so far */
    protected int $inputs = 0;

    /**
     * Prepare a run.
     *
     * @param array $program algorithm model (decoded JSON)
     * @param int $maxsteps step limit
     */
    public function __construct(array $program, int $maxsteps = 1000000) {
        $this->program = $program;
        $this->maxsteps = $maxsteps;
        foreach ($program['functions'] ?? [] as $f) {
            $this->funcs[strtolower((string) ($f['name'] ?? ''))] = $f;
        }
    }

    /**
     * Run the algorithm.
     *
     * @param callable $input function (string $name, string $type): string giving the next input; it may throw
     * @return array output pieces [text, number of inputs read before it]
     * @throws algorithm_error when the algorithm stops with an error ($this->output() still has what it wrote)
     */
    public function run(callable $input): array {
        $this->input = $input;
        $functions = $this->program['functions'] ?? [];
        if (!$functions) {
            throw new algorithm_error('badexpression');
        }
        $main = $this->funcs['main'] ?? $functions[0];
        $this->call_function($main, []);
        return $this->output;
    }

    /**
     * Output written so far.
     *
     * @return array pieces [text, number of inputs read before it]
     */
    public function output(): array {
        return $this->output;
    }

    /**
     * Number of inputs read so far.
     *
     * @return int
     */
    public function inputs_read(): int {
        return $this->inputs;
    }

    /**
     * Parsed expression (cached).
     *
     * @param mixed $src expression text
     * @return array AST
     */
    protected function ast($src): array {
        $src = js::to_string($src);
        if (!isset($this->cache[$src])) {
            $this->cache[$src] = expr::parse($src);
        }
        return $this->cache[$src];
    }

    /**
     * Is there text (not only spaces)?
     *
     * @param mixed $s value
     * @return bool
     */
    protected static function has_text($s): bool {
        return $s !== null && trim(js::to_string($s)) !== '';
    }

    /**
     * Initial value of a variable.
     *
     * @param mixed $type variable type
     * @return mixed
     */
    protected static function default_value($type) {
        return ['Integer' => 0.0, 'Real' => 0.0, 'String' => '', 'Boolean' => false][$type] ?? null;
    }

    /**
     * Convert a value for a variable of a type.
     *
     * @param mixed $type variable type
     * @param mixed $value value
     * @param string $name variable name (for the error message)
     * @return mixed
     */
    protected static function coerce($type, $value, string $name) {
        $bad = is_bool($value) || (is_string($value) && is_nan(js::to_number($value)));
        switch ($type) {
            case 'Integer':
                if ($bad) {
                    throw new algorithm_error('assigninteger', ['value' => js::to_string($value), 'name' => $name]);
                }
                return js::trunc(js::to_number($value));
            case 'Real':
                if ($bad) {
                    throw new algorithm_error('assignreal', ['value' => js::to_string($value), 'name' => $name]);
                }
                return js::to_number($value);
            case 'Boolean':
                if (!is_bool($value)) {
                    throw new algorithm_error('assignboolean', ['value' => js::to_string($value), 'name' => $name]);
                }
                return $value;
            default:
                return js::to_string($value);
        }
    }

    /**
     * Count a step; too many steps stop the algorithm.
     */
    protected function tick(): void {
        if (++$this->steps > $this->maxsteps) {
            throw new algorithm_error('steplimit');
        }
    }

    /**
     * Variable of a scope.
     *
     * @param array $env variables of the function call
     * @param string $name variable name
     * @return \stdClass
     */
    protected static function lookup(array $env, string $name): \stdClass {
        $v = $env[strtolower($name)] ?? null;
        if (!$v) {
            throw new algorithm_error('notdeclared', ['name' => $name]);
        }
        return $v;
    }

    /**
     * Element of an array a[i] or a matrix a[i, j]: the variable, the array that holds the element and its index.
     *
     * @param array $n idx node
     * @param array $env variables
     * @return array [variable, js_array, index]
     */
    protected function array_index(array $n, array $env): array {
        $v = self::lookup($env, $n['name']);
        if (!($v->value instanceof js_array)) {
            throw new algorithm_error('notarray', ['name' => $n['name']]);
        }
        $dims = empty($v->dims) ? 1 : $v->dims;
        if ((isset($n['index2']) ? 2 : 1) !== $dims) {
            throw new algorithm_error('dimensions', ['name' => $n['name'], 'count' => (string) $dims]);
        }
        $i = $this->eval_node($n['index'], $env);
        self::check_range($v->value, $i, $n['name']);
        if (!isset($n['index2'])) {
            return [$v, $v->value, $i];
        }
        $j = $this->eval_node($n['index2'], $env);
        $row = self::element($v->value, $i);
        if (!($row instanceof js_array)) {
            throw new algorithm_error('indexrange', ['index' => js::to_string($i), 'name' => $n['name']]);
        }
        self::check_range($row, $j, $n['name']);
        return [$v, $row, $j];
    }

    /**
     * An index must be at least 0 and smaller than the length (compared as in JavaScript).
     *
     * @param js_array $a array
     * @param mixed $i index
     * @param string $name name of the variable, for the error
     */
    protected static function check_range(js_array $a, $i, string $name): void {
        if (js::compare($i, 0.0) === -1 || in_array(js::compare($i, (float) count($a->items)), [0, 1], true)) {
            throw new algorithm_error('indexrange', ['index' => js::to_string($i), 'name' => $name]);
        }
    }

    /**
     * Length of a new array, as JavaScript's Array.from({length}) reads it.
     *
     * @param mixed $size size value
     * @return int
     */
    protected static function array_length($size): int {
        $length = js::to_number($size);
        return is_nan($length) || $length < 0 ? 0 : (int) js::trunc($length);
    }

    /**
     * Element of an array (undefined for an index that is not a whole number).
     *
     * @param js_array $a array
     * @param mixed $i index
     * @return mixed
     */
    protected static function element(js_array $a, $i) {
        return js::is_integer($i) ? ($a->items[(int) $i] ?? null) : null;
    }

    /**
     * Binary operator.
     *
     * @param string $op operator
     * @param mixed $l left value
     * @param mixed $r right value
     * @return mixed
     */
    protected static function binary(string $op, $l, $r) {
        switch ($op) {
            case '+':
                if (is_string($l) || is_string($r)) {
                    return js::fmt($l) . js::fmt($r);
                }
                return js::to_number($l) + js::to_number($r);
            case '&':
                return js::fmt($l) . js::fmt($r);
            case '-':
                return js::to_number($l) - js::to_number($r);
            case '*':
                return js::to_number($l) * js::to_number($r);
            case '/':
            case '%':
                if (is_float($r) && $r == 0) {
                    throw new algorithm_error('divzero');
                }
                $a = js::to_number($l);
                $b = js::to_number($r);
                return $op === '/' ? fdiv($a, $b) : fmod($a, $b);
            case '^':
                return @pow(js::to_number($l), js::to_number($r));
            case '==':
                return js::strict_equals($l, $r);
            case '!=':
                return !js::strict_equals($l, $r);
            case '<':
                return js::compare($l, $r) === -1;
            case '<=':
                return in_array(js::compare($l, $r), [-1, 0], true);
            case '>':
                return js::compare($l, $r) === 1;
            case '>=':
                return in_array(js::compare($l, $r), [0, 1], true);
            default:
                throw new algorithm_error('badoperator', ['op' => $op]);
        }
    }

    /**
     * Built-in function.
     *
     * @param string $name lower case name
     * @param array $args argument values
     * @return mixed
     */
    protected static function builtin(string $name, array $args) {
        $a = $args[0] ?? null;
        $num = fn() => js::to_number($a);
        switch ($name) {
            case 'abs':
                return abs($num());
            case 'sqrt':
                return sqrt($num());
            case 'sin':
                return sin($num());
            case 'cos':
                return cos($num());
            case 'tan':
                return tan($num());
            case 'log':
                return log($num());
            case 'exp':
                return exp($num());
            case 'floor':
                return floor($num());
            case 'ceiling':
                return ceil($num());
            case 'round':
                return js::round($num());
            case 'int':
                return js::trunc($num());
            case 'sign':
                $x = $num();
                return is_nan($x) ? NAN : (float) ($x <=> 0);
            case 'random':
                return floor(mt_rand() / (mt_getrandmax() + 1) * $num());
            case 'len':
                return (float) ($a instanceof js_array ? count($a->items) : js::length(js::to_string($a)));
            case 'char':
                if (count($args) < 2 || $args[1] === null) {
                    return js::from_char_code($a);
                }
                $text = js::to_string($a);
                $k = js::to_number($args[1]);
                if (!js::is_integer($k) || $k < 0 || $k >= js::length($text)) {
                    throw new algorithm_error('charindex', ['index' => js::to_string($args[1]), 'text' => $text]);
                }
                return js::char_at($text, (int) $k);
            case 'tochar':
                return js::from_char_code($a);
            case 'tocode':
                if (js::to_string($a) === '') {
                    throw new algorithm_error('tocodeempty');
                }
                return (float) js::code_at(js::to_string($a), 0);
            case 'toint':
                return js::trunc($num());
            case 'toreal':
                return $num();
            case 'tostring':
                return js::to_string($a);
            case 'isnumeric':
                return $a !== '' && !is_nan($num());
            case 'pi':
                return M_PI;
        }
        return null;
    }

    /** Names of the built-in functions. */
    const BUILTINS = ['abs', 'sqrt', 'sin', 'cos', 'tan', 'log', 'exp', 'floor', 'ceiling', 'round', 'int', 'sign', 'random',
        'len', 'char', 'tochar', 'tocode', 'toint', 'toreal', 'tostring', 'isnumeric', 'pi'];

    /**
     * Value of an expression.
     *
     * @param array $n AST node
     * @param array $env variables
     * @return mixed
     */
    protected function eval_node(array $n, array $env) {
        switch ($n['k']) {
            case 'num':
            case 'str':
            case 'bool':
                return $n['v'];
            case 'var':
                return self::lookup($env, $n['name'])->value;
            case 'idx':
                [, $list, $i] = $this->array_index($n, $env);
                return self::element($list, $i);
            case 'un':
                $e = $this->eval_node($n['e'], $env);
                if ($n['op'] === '-') {
                    return -js::to_number($e);
                }
                return $n['op'] === '!' ? !js::truthy($e) : $e;
            case 'bin':
                $l = $this->eval_node($n['l'], $env);
                if ($n['op'] === '&&') {
                    return js::truthy($l) ? js::truthy($this->eval_node($n['r'], $env)) : false;
                }
                if ($n['op'] === '||') {
                    return js::truthy($l) ? true : js::truthy($this->eval_node($n['r'], $env));
                }
                return self::binary($n['op'], $l, $this->eval_node($n['r'], $env));
            case 'call':
                $args = [];
                foreach ($n['args'] as $arg) {
                    $args[] = $this->eval_node($arg, $env);
                }
                $lname = strtolower($n['name']);
                if (isset($this->funcs[$lname])) {
                    return $this->call_function($this->funcs[$lname], $args);
                }
                if (in_array($lname, self::BUILTINS, true)) {
                    return self::builtin($lname, $args);
                }
                throw new algorithm_error('unknownfunction', ['name' => $n['name']]);
            default:
                throw new algorithm_error('badexpression');
        }
    }

    /**
     * Value of an expression given as text.
     *
     * @param mixed $src expression text
     * @param array $env variables
     * @return mixed
     */
    protected function eval_str($src, array $env) {
        return $this->eval_node($this->ast($src), $env);
    }

    /**
     * Store a value in a variable or array element.
     *
     * @param mixed $target assignment target (text)
     * @param mixed $value value
     * @param array $env variables
     */
    protected function assign($target, $value, array $env): void {
        $t = $this->ast($target);
        if ($t['k'] === 'var') {
            $v = self::lookup($env, $t['name']);
            $v->value = self::coerce($v->type, $value, $t['name']);
        } else if ($t['k'] === 'idx') {
            [$v, $list, $i] = $this->array_index($t, $env);
            $value = self::coerce($v->type, $value, $t['name']);
            if (js::is_integer($i)) {
                $list->items[(int) $i] = $value;
            }
        } else {
            throw new algorithm_error('badtarget');
        }
    }

    /**
     * Run blocks in order.
     *
     * @param mixed $list blocks
     * @param array $env variables
     * @return array|null ['return', value] when a Return block ran
     */
    protected function run_list($list, array &$env): ?array {
        foreach (is_array($list) ? $list : [] as $b) {
            $r = $this->run_block($b, $env);
            if ($r) {
                return $r;
            }
        }
        return null;
    }

    /**
     * Input block: read the next value.
     *
     * @param array $b block
     * @param array $env variables
     */
    protected function run_input(array $b, array $env): void {
        $t = $this->ast($b['target'] ?? '');
        $decl = self::lookup($env, $t['name']);
        $text = (string) ($this->input)((string) ($b['target'] ?? ''), (string) $decl->type);
        $this->inputs++;
        $val = $text;
        if ($decl->type === 'Boolean') {
            $val = strtolower(js::trim($text)) === 'true';
        } else if ($decl->type !== 'String') {
            $val = js::to_number($text);
            if (js::trim($text) === '' || is_nan($val)) {
                throw new algorithm_error('invalidinput', ['text' => $text, 'type' => $decl->type]);
            }
        }
        $this->assign($b['target'], $val, $env);
    }

    /**
     * For block.
     *
     * @param array $b block
     * @param array $env variables
     * @return array|null return marker
     */
    protected function run_for(array $b, array &$env): ?array {
        $start = $this->eval_str($b['start'] ?? '', $env);
        $end = $this->eval_str($b['end'] ?? '', $env);
        $step = self::has_text($b['step'] ?? null) ? $this->eval_str($b['step'], $env) : 1.0;
        if (is_float($step) && $step == 0) {
            throw new algorithm_error('forstepzero');
        }
        $key = strtolower((string) ($b['variable'] ?? ''));
        if (!isset($env[$key])) {
            $env[$key] = (object) ['type' => 'Integer', 'value' => 0.0, 'name' => $b['variable']];
        }
        $up = js::compare($step, 0.0) === 1;
        for ($i = $start; in_array(js::compare($i, $end), $up ? [-1, 0] : [0, 1], true); $i = self::binary('+', $i, $step)) {
            $env[$key]->value = $i;
            $r = $this->run_list($b['body'] ?? [], $env);
            if ($r) {
                return $r;
            }
            $this->tick();
        }
        return null;
    }

    /**
     * Run one block.
     *
     * @param mixed $b block
     * @param array $env variables
     * @return array|null return marker
     */
    protected function run_block($b, array &$env): ?array {
        $this->tick();
        if (!is_array($b)) {
            return null;
        }
        switch ($b['type'] ?? '') {
            case 'declare':
                // A second size makes a matrix (rows, columns).
                $size = self::has_text($b['size'] ?? null) ? $this->eval_str($b['size'], $env) : null;
                $size2 = $size !== null && self::has_text($b['size2'] ?? null) ? $this->eval_str($b['size2'], $env) : null;
                $total = $size === null ? 0 : js::to_number($size) * ($size2 === null ? 1 : js::to_number($size2));
                if ($size !== null && $total > self::MAX_ARRAY_SIZE) {
                    $shown = $size2 === null ? js::to_string($size) : js::to_string($size) . ' x ' . js::to_string($size2);
                    throw new algorithm_error('arraysize', ['size' => $shown, 'max' => (string) self::MAX_ARRAY_SIZE]);
                }
                $names = array_filter(array_map('trim', explode(',', js::to_string($b['name'] ?? ''))), 'strlen');
                foreach ($names as $nm) {
                    $type = $b['varType'] ?? null;
                    if ($size === null) {
                        $value = self::default_value($type);
                    } else {
                        $value = new js_array([]);
                        for ($k = 0; $k < self::array_length($size); $k++) {
                            $value->items[] = $size2 === null ? self::default_value($type) :
                                new js_array(array_fill(0, self::array_length($size2), self::default_value($type)));
                        }
                    }
                    $dims = $size === null ? 0 : ($size2 === null ? 1 : 2);
                    $env[strtolower($nm)] = (object) ['name' => $nm, 'type' => $type, 'value' => $value, 'dims' => $dims];
                }
                break;
            case 'assign':
                $this->assign($b['target'] ?? '', $this->eval_str($b['expr'] ?? '', $env), $env);
                break;
            case 'input':
                $this->run_input($b, $env);
                break;
            case 'output':
                $v = $this->eval_str($b['expr'] ?? '', $env);
                $this->output[] = [js::fmt($v) . (($b['newline'] ?? true) === false ? '' : "\n"), $this->inputs];
                break;
            case 'if':
                $branch = js::truthy($this->eval_str($b['cond'] ?? '', $env)) ? ($b['then'] ?? []) : ($b['else'] ?? []);
                return $this->run_list($branch, $env);
            case 'while':
                while (js::truthy($this->eval_str($b['cond'] ?? '', $env))) {
                    $r = $this->run_list($b['body'] ?? [], $env);
                    if ($r) {
                        return $r;
                    }
                    $this->tick();
                }
                break;
            case 'dowhile':
                do {
                    $r = $this->run_list($b['body'] ?? [], $env);
                    if ($r) {
                        return $r;
                    }
                    $this->tick();
                } while (js::truthy($this->eval_str($b['cond'] ?? '', $env)));
                break;
            case 'for':
                return $this->run_for($b, $env);
            case 'call':
                $this->eval_str($b['expr'] ?? '', $env);
                break;
            case 'return':
                return ['return', self::has_text($b['expr'] ?? null) ? $this->eval_str($b['expr'], $env) : null];
        }
        return null;
    }

    /**
     * Call a user function.
     *
     * @param array $fn function model
     * @param array $args argument values
     * @return mixed return value (null when none)
     */
    protected function call_function(array $fn, array $args) {
        $params = $fn['params'] ?? [];
        if (count($args) !== count($params)) {
            throw new algorithm_error('argcount', ['name' => $fn['name'], 'count' => (string)count($params)]);
        }
        $env = [];
        foreach ($params as $i => $p) {
            $env[strtolower($p['name'])] = (object) ['name' => $p['name'], 'type' => $p['type'] ?? null,
                'value' => !empty($p['array']) ? $args[$i] : self::coerce($p['type'] ?? null, $args[$i], $p['name'])];
        }
        $r = $this->run_list($fn['body'] ?? [], $env);
        return $r ? $r[1] : null;
    }
}
