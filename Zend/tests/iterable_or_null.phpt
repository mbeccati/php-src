--TEST--
Test Z_PARAM_ITERABLE() and Z_PARAM_ITERABLE_OR_NULL
--SKIPIF--
<?php
if (!extension_loaded('zend_test')) die('skip zend_test extension not loaded');
?>
--FILE--
<?php

try {
	  var_dump(zend_iterable("string"));
} catch (TypeError $exception) {
    echo $exception->getMessage() . "\n";
}

try {
	  var_dump(zend_iterable(1));
} catch (TypeError $exception) {
    echo $exception->getMessage() . "\n";
}

try {
	  var_dump(zend_iterable(null));
} catch (TypeError $exception) {
    echo $exception->getMessage() . "\n";
}


zend_iterable([]);
zend_iterable([], []);

$iterator = new ArrayIterator([]);
zend_iterable($iterator);
zend_iterable($iterator, $iterator);
zend_iterable($iterator, null);

try {
	  var_dump(zend_iterable([], "string"));
} catch (TypeError $exception) {
    echo $exception->getMessage() . "\n";
}

?>
--EXPECT--
zend_iterable(): Argument #1 ($arg1) must be of type iterable, string given
zend_iterable(): Argument #1 ($arg1) must be of type iterable, int given
zend_iterable(): Argument #1 ($arg1) must be of type iterable, null given
zend_iterable(): Argument #2 ($arg2) must be of type ?iterable, string given

