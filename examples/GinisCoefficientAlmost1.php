<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Macocci7\PhpLorenzCurve\LorenzCurve;

$lc = new LorenzCurve();

$data = array_fill(0, 500, 0);
$data[] = 5;

$lc
    ->setData($data)
    ->setClassRange(5)
    ->grid(1, '#ffcccc')
    ->create('img/GinisCoefficientAlmost1.png');

var_dump($lc->getGinisCoefficient());
