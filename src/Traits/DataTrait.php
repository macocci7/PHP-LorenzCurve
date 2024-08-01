<?php

namespace Macocci7\PhpLorenzCurve\Traits;

use Macocci7\PhpFrequencyTable\FrequencyTable;

trait DataTrait
{
    protected FrequencyTable $ft;

    /**
     * @var array<string, mixed>    $parsed = []
     */
    protected array $parsed = [];

    /**
     * sets data
     *
     * @param   array<int|string, int|float>    $data
     * @return  self
     */
    public function setData(array $data)
    {
        $this->ft->setData($data);
        return $this;
    }

    /**
     * returns data
     *
     * @return  array<int|string, int|float>
     */
    public function getData()
    {
        return $this->ft->getData();
    }

    /**
     * sets class range
     *
     * @param   int|float   $classRange
     * @return  self
     */
    public function setClassRange(int|float $classRange)
    {
        $this->ft->setClassRange($classRange);
        return $this;
    }

    /**
     * sets list of classes in reverse order
     *
     * @return self
     */
    public function reverseClasses()
    {
        $this->ft->reverseClasses();
        return $this;
    }

    /**
     * returns points to plot
     *
     * @return  array<int, array<int, int|float>>
     */
    public function getPoints()
    {
        if (count($this->ft->getData()) === 1) {
            return [[1, 0], [1, 1]];
        }
        $frequencies = $this->parsed['Frequencies'];
        $subtotals = $this->ft->getCumulativeRelativeSubtotals();
        $count = count($frequencies);
        $points = [];
        for ($i = 0; $i < $count; $i++) {
            $crf = $this->ft->getCumulativeRelativeFrequency(
                $frequencies,
                $i,
            );
            $subtotal = $subtotals[$i];
            $points[] = [$crf, $subtotal];
        }
        return $points;
    }

    /**
     * returns the Gini's Coefficient
     *
     * @return  int|float
     */
    public function getGinisCoefficient()
    {
        $this->parsed = $this->ft->parse();
        $points = $this->getPoints();
        $count = count($points);
        $points[-1] = [0, 0];
        $gc = [];
        for ($i = 0; $i < $count; $i++) {
            $gc[] = $this->getArea($points[$i - 1], $points[$i]);
        }
        return array_sum($gc) * 2;
    }

    /**
     * returns the area
     * @param   int[]   $p1
     * @param   int[]   $p2
     * @return  int|float
     */
    protected function getArea(
        array $p1,
        array $p2,
    ) {
        list($x1, $y1) = $p1;
        list($x2, $y2) = $p2;
        if (($x1 - $y1) == 0 && ($x2 - $y2) == 0) {
            // in case the points are on the complete equality line
            return 0;
        }
        if (($x1 - $y1) * ($x2 - $y2) >= 0) {
            // in case the shape is a trapezoid
            return (abs($x1 - $y1) + abs($x2 - $y2)) * abs($x2 - $x1) / 2;
        }
        // in case the butterfly shape
        return (($x1 - $y1) ** 2 + ($x2 - $y2) ** 2) * abs($x2 - $x1)
            / (2 * (abs($x1 - $y1) + abs($x2 - $y2)));
    }
}
