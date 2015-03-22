--TEST--
ReflectionParameter::hasTypeHint() / getTypeHint()
--FILE--
<?php
function foo(stdClass $a, array $b, callable $c, stdClass $d = null, $e = null, string $f, bool $g, int $h, float $i) { }

function bar(): stdClass { return new stdClass; }

class c { function bar(): int { return 1; } }

$rf = new ReflectionFunction('foo');
foreach ($rf->getParameters() as $idx => $rp) {
  echo "** Parameter $idx\n";
  var_dump($rp->hasTypeHint());
  $ra = $rp->getTypeHint();
  if ($ra) {
    var_dump($ra->isArray());
    var_dump($ra->isCallable());
    var_dump($ra->isNullable());
    var_dump($ra->isInstance());
    var_dump($ra->isScalar());
    var_dump((string)$ra);
  }
}
foreach (array($rf, new ReflectionFunction('bar'), new ReflectionMethod('c', 'bar')) as $idx => $rf) {
  echo "** Function/method return type $idx\n";
  var_dump($rf->hasReturnTypeHint());
  $ra = $rf->getReturnTypeHint();
  if ($ra) {
    var_dump($ra->isArray());
    var_dump($ra->isCallable());
    var_dump($ra->isNullable());
    var_dump($ra->isInstance());
    var_dump($ra->isScalar());
    var_dump((string)$ra);
  }
}
--EXPECT--
** Parameter 0
bool(true)
bool(false)
bool(false)
bool(false)
bool(true)
bool(false)
string(8) "stdClass"
** Parameter 1
bool(true)
bool(true)
bool(false)
bool(false)
bool(false)
bool(false)
string(5) "array"
** Parameter 2
bool(true)
bool(false)
bool(true)
bool(false)
bool(false)
bool(false)
string(8) "callable"
** Parameter 3
bool(true)
bool(false)
bool(false)
bool(true)
bool(true)
bool(false)
string(8) "stdClass"
** Parameter 4
bool(false)
** Parameter 5
bool(true)
bool(false)
bool(false)
bool(false)
bool(false)
bool(true)
string(6) "string"
** Parameter 6
bool(true)
bool(false)
bool(false)
bool(false)
bool(false)
bool(true)
string(4) "bool"
** Parameter 7
bool(true)
bool(false)
bool(false)
bool(false)
bool(false)
bool(true)
string(3) "int"
** Parameter 8
bool(true)
bool(false)
bool(false)
bool(false)
bool(false)
bool(true)
string(5) "float"
** Function/method return type 0
bool(false)
** Function/method return type 1
bool(true)
bool(false)
bool(false)
bool(false)
bool(true)
bool(false)
string(8) "stdClass"
** Function/method return type 2
bool(true)
bool(false)
bool(false)
bool(false)
bool(false)
bool(true)
string(3) "int"
