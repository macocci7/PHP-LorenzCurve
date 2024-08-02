<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Macocci7\PhpLorenzCurve\LorenzCurve;

$lc = new LorenzCurve();

$lc
    ->setData([1, 5, 10, 15, 20])
    ->setClassRange(5)
    ->grid(1, '#ffcccc')
    ->plotarea(
        offset: [80, 50],
        width: 280,
        height: 200,
        backgroundColor: '#eeeeee',
    )
    ->create('img/SetPlotareaAttrs.png');
