<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Macocci7\PhpLorenzCurve\LorenzCurve;

$lc = new LorenzCurve();

$lc
    ->setData([1, 5, 10, 15, 20])
    ->setClassRange(5)
    ->config([
        'canvasBackgroundColor' => '#3333cc',
        'showGrid' => true,
        'gridWidth' => 1,
        'gridColor' => '#0066ff',
        'axisWidth' => 3,
        'axisColor' => '#ffffff',
        'scaleWidth' => 2,
        'scaleLength' => 6,
        'scaleColor' => '#ffffff',
        'scaleFontSize' => 14,
        'scaleFontColor' => '#ffffff',
        'lorenzCurveWidth' => 1,
        'lorenzCurveColor' => '#ffff00',
        'lorenzCurveBackgroundColor' => null, // transparent
        'completeEqualityLineWidth' => 3,
        'completeEqualityLineColor' => '#ffffff',
        'completeEqualityLineDash' => [8, 8],
        'fontColor' => '#ffffff',
        'caption' => 'Config From Array',
    ])
    ->create('img/ConfigFromArray.png');
