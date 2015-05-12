<?php

require('Exceptions.php');
require('Flatten.php');

$source = $_GET['source'];
// Obviously in the real world, this would be escaped / sanitised using our framework of choice.

$data = json_decode($source);

$flatten = new Flatten();
$result = $flatten->run($data);

header('Content-Type: application/json');
echo json_encode($result, true);
