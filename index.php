<?php
include_once("t9.class.php");

$input = "3509";

$t9 = new T9();
$t9->addDictionary(__DIR__ . '/dictionary.txt',str_split($t9->key[$input[0]]));
$result = $t9->getWords($input);
var_dump($result);
?>