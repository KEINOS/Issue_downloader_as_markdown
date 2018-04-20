<?php

include('Functions.php');
include('Classes.php');

$msg = 'Hello World!';

/* Function */
echo return_message($msg) . PHP_EOL;

/* Class */
echo MyClass::return_message($msg) . PHP_EOL;

$test = new MyClass();
$test->echo_message($msg); echo PHP_EOL;