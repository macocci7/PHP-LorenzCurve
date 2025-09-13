<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Macocci7\PhpLorenzCurve\LorenzCurve;

$parsed = (new LorenzCurve())
    ->setData([1, 5, 10, 15, 20])
    ->setClassRange(5)
    ->parse();

var_dump($parsed);
