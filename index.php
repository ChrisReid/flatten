<?php

require('Exceptions.php');
require('Flatten.php');

$flatten = new Flatten();
$flatten->loadConfig('config.php');
$success = $flatten->run();

var_dump($success);
