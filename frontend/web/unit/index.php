<?php
namespace test;

include_once 'calculator.php';

echo Calculator::divide(10, 2);

echo '<br>';
var_dump(Calculator::divide(10, 0));

echo '<br>';
var_dump(Calculator::divide(10, 10));

echo '<br>';
var_dump(Calculator::add(15,2));
