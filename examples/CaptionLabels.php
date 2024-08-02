<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Macocci7\PhpLorenzCurve\LorenzCurve;

$lc = new LorenzCurve();

$lc
    ->setData([1, 5, 10, 15, 20])
    ->setClassRange(5)
    ->grid(1, '#ffcccc')
    ->plotarea(offset: [60, 40])
    ->caption('CAPTION')
    ->labelX('Cumulative Relative Frequency', offsetX: 0, offsetY: 10)
    ->labelY('Cumulative Relative Subtotal')
    ->create('img/CaptionLabels.png');
