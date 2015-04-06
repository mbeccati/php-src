--TEST--
ReflectionParameter::hasType() / getType()
--FILE--
<?php
function foo(stdClass $a, array $b, callable $c, stdClass $d = null, $e = null, string $f, bool $g, int $h, float $i) { }

function bar(): stdClass { return new stdClass; }

class c extends stdClass {
  function bar(self $x): int { return 1; }
  function pbar(parent $x): int { return 1; }
  function factory(): self { return new c; }
  function pfactory(): parent { return new stdClass; }
}

echo "*** function foo\n";

$rf = new ReflectionFunction('foo');
foreach ($rf->getParameters() as $idx => $rp) {
  echo "** Parameter $idx\n";
  var_dump($rp->hasType());
  $ra = $rp->getType();
  if ($ra) {
    var_dump($ra->allowsNull());
    var_dump($ra->isClassOrInterface());
    var_dump((string)$ra);
  }
}

echo "\n*** methods\n";

foreach ([
  new ReflectionMethod('SplObserver', 'update'),
  new ReflectionMethod('c', 'bar'),
  new ReflectionMethod('c', 'pbar'),
] as $idx => $rm) {
  foreach ($rm->getParameters() as $idx2 => $rp) {
    echo "** Method $idx - parameter $idx2\n";
    var_dump($rp->hasType());
    $ra = $rp->getType();
    if ($ra) {
      var_dump($ra->allowsNull());
      var_dump($ra->isClassOrInterface());
      var_dump((string)$ra);
    }
  }
}

echo "\n*** return types\n";

foreach ([
  new ReflectionMethod('SplObserver', 'update'),
  new ReflectionFunction('bar'),
  new ReflectionMethod('c', 'bar'),
  new ReflectionMethod('c', 'factory'),
  new ReflectionMethod('c', 'pfactory'),
] as $idx => $rf) {
  echo "** Function/method return type $idx\n";
  var_dump($rf->hasReturnType());
  $ra = $rf->getReturnType();
  if ($ra) {
    var_dump($ra->allowsNull());
    var_dump($ra->isClassOrInterface());
    var_dump((string)$ra);
  }
}
--EXPECT--
*** function foo
** Parameter 0
bool(true)
bool(false)
bool(true)
string(8) "stdClass"
** Parameter 1
bool(true)
bool(false)
bool(false)
string(5) "array"
** Parameter 2
bool(true)
bool(false)
bool(false)
string(8) "callable"
** Parameter 3
bool(true)
bool(true)
bool(true)
string(8) "stdClass"
** Parameter 4
bool(false)
** Parameter 5
bool(true)
bool(false)
bool(false)
string(6) "string"
** Parameter 6
bool(true)
bool(false)
bool(false)
string(4) "bool"
** Parameter 7
bool(true)
bool(false)
bool(false)
string(3) "int"
** Parameter 8
bool(true)
bool(false)
bool(false)
string(5) "float"

*** methods
** Method 0 - parameter 0
bool(true)
bool(false)
bool(true)
string(10) "SplSubject"
** Method 1 - parameter 0
bool(true)
bool(false)
bool(true)
string(4) "self"
** Method 2 - parameter 0
bool(true)
bool(false)
bool(true)
string(6) "parent"

*** return types
** Function/method return type 0
bool(false)
** Function/method return type 1
bool(true)
bool(false)
bool(true)
string(8) "stdClass"
** Function/method return type 2
bool(true)
bool(false)
bool(false)
string(3) "int"
** Function/method return type 3
bool(true)
bool(false)
bool(true)
string(4) "self"
** Function/method return type 4
bool(true)
bool(false)
bool(true)
string(6) "parent"
