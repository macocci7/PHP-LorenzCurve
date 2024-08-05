<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Macocci7\PhpLorenzCurve\LorenzCurve;

$lc = new LorenzCurve();

$lc
    ->setData([1, 5, 10, 15, 20])
    ->setClassRange(5)
    ->config('ConfigFromFile.neon')
    ->create('img/ConfigFromFile.png');
