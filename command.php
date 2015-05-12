<?php

require('Exceptions.php');
require('Flatten.php');

try {
    if (count($argv) < 3) {
        throw new InvalidArgumentException('Please specify a source and destination.');
    }

    list (, $source, $destination) = $argv;

    $flatten = new Flatten($source, $destination);
    $success = $flatten->run();

    print $success ? "'$destination' written." : 'Write failure.';
    print PHP_EOL;
}
catch (Exception $e) {
    print ( $e->getMessage() . PHP_EOL );
    die;
}