<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Macocci7\PhpLorenzCurve\LorenzCurve;

$lc = new LorenzCurve();

$lc
    ->setData([1])
    ->setClassRange(5)
    ->grid(1, '#ffcccc')
    ->create('img/GinisCoefficient1.png');

var_dump($lc->getGinisCoefficient());
