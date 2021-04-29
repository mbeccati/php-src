--TEST--
Bug #80892 PDO::PARAM_INT is treated the same as PDO::PARAM_STR - Edge cases
--SKIPIF--
<?php
if (!extension_loaded('pdo') || !extension_loaded('pdo_pgsql')) die('skip not loaded');
require __DIR__ . '/config.inc';
require __DIR__ . '/../../../ext/pdo/tests/pdo_test.inc';
PDOTest::skip();
?>
--FILE--
<?php
require __DIR__ . '/../../../ext/pdo/tests/pdo_test.inc';

/** @var PDO $db */
$db = PDOTest::test_factory(__DIR__ . '/common.phpt');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$db->setAttribute(PDO::ATTR_STRINGIFY_FETCHES, false);

$db->exec("CREATE TEMPORARY TABLE b80892 (a int, b smallint)");

$stmt = $db->prepare("INSERT INTO b80892 (a, b) VALUES (?, ?) RETURNING *");
$stmt->bindValue(1, 1, PDO::PARAM_STR);
$stmt->bindValue(2, 1, PDO::PARAM_STR);
$stmt->execute();
var_dump($stmt->fetch());

$stmt = $db->prepare("INSERT INTO b80892 (a, b) VALUES (?, ?) RETURNING *");
$stmt->bindValue(1, 1, PDO::PARAM_INT);
$stmt->bindValue(2, 1, PDO::PARAM_INT);
$stmt->execute();
var_dump($stmt->fetch());

$stmt = $db->prepare("INSERT INTO b80892 (a, b) VALUES (?, ?) RETURNING *");
$stmt->bindValue(1, true, PDO::PARAM_INT);
$stmt->bindValue(2, true, PDO::PARAM_INT);
$stmt->execute();
var_dump($stmt->fetch());

$stmt = $db->prepare("INSERT INTO b80892 (a, b) VALUES (?, ?) RETURNING *");
$stmt->bindValue(1, false, PDO::PARAM_INT);
$stmt->bindValue(2, false, PDO::PARAM_INT);
$stmt->execute();
var_dump($stmt->fetch());

$stmt = $db->prepare("INSERT INTO b80892 (a, b) VALUES (?, ?) RETURNING *");
$stmt->bindValue(1, null, PDO::PARAM_INT);
$stmt->bindValue(2, null, PDO::PARAM_INT);
$stmt->execute();
var_dump($stmt->fetch());

?>
--EXPECT--
array(2) {
  ["a"]=>
  int(1)
  ["b"]=>
  int(1)
}
array(2) {
  ["a"]=>
  int(1)
  ["b"]=>
  int(1)
}
array(2) {
  ["a"]=>
  int(1)
  ["b"]=>
  int(1)
}
array(2) {
  ["a"]=>
  int(0)
  ["b"]=>
  int(0)
}
array(2) {
  ["a"]=>
  NULL
  ["b"]=>
  NULL
}
