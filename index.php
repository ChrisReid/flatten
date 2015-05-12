<?php

require('Flatten.php');

$flatten = new Flatten();
$success = $flatten->run();

var_dump($success);
