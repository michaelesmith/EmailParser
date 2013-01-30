<?php

error_reporting(E_ALL);

if (!file_exists($autoload = __DIR__ . '/../vendor/autoload.php')) {
    die('You must run "composer install" to generate vendor/autoload.php before running tests' . "\n");
}

$loader = require $autoload;
$loader->add('MS\\Email\\Parser\\Test', __DIR__);
