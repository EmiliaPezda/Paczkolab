<?php
require 'load.php';




$class=new User();
$result = $class->load(21);

var_dump($result);
$result->setName('Janusz');
var_dump($result->update());
var_dump($result->getId());
$result2 = $class->load(21);
var_dump($result2);