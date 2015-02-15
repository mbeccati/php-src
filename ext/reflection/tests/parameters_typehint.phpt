--TEST--
ReflectionParameter::hasTypeAnnotation() / getTypeAnnotation()
--FILE--
<?php
function foo(stdClass $a, array $b, callable $c, stdClass $d = null, $e = null) { }

function bar():stdClass { return new stdClass; }

class c { function bar():stdClass { return bar(); } }

$rf = new ReflectionFunction('foo');
foreach ($rf->getParameters() as $idx => $rp) {
  echo "** Parameter $idx\n";
  var_dump($rp->hasTypeAnnotation());
  $ra = $rp->getTypeAnnotation();
  if ($ra) {
    var_dump($ra->isArray());
    var_dump($ra->isCallable());
    var_dump($ra->isNullable());
    var_dump($ra->isInstance());
    var_dump((string)$ra);
  }
}
foreach (array($rf, new ReflectionFunction('bar'), new ReflectionMethod('c', 'bar')) as $idx => $rf) {
  echo "** Function/method return type $idx\n";
  var_dump($rf->hasReturnTypeAnnotation());
  $ra = $rf->getReturnTypeAnnotation();
  if ($ra) {
    var_dump($ra->isArray());
    var_dump($ra->isCallable());
    var_dump($ra->isNullable());
    var_dump($ra->isInstance());
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
string(8) "stdClass"
** Parameter 1
bool(true)
bool(true)
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
string(8) "callable"
** Parameter 3
bool(true)
bool(false)
bool(false)
bool(true)
bool(true)
string(8) "stdClass"
** Parameter 4
bool(false)
** Function/method return type 0
bool(false)
** Function/method return type 1
bool(true)
bool(false)
bool(false)
bool(false)
bool(true)
string(8) "stdClass"
** Function/method return type 2
bool(true)
bool(false)
bool(false)
bool(false)
bool(true)
string(8) "stdClass"
