<?php

namespace Macocci7\PhpLorenzCurve\Traits;

use Macocci7\PhpPlotter2d\Plotter;
use Macocci7\PhpPlotter2d\Canvas;
use Macocci7\PhpPlotter2d\Transformer;

trait PlotterTrait
{
    protected Canvas $canvas;
    protected Transformer $transformer;

    /**
     * sets props
     */
    protected function setProps(): void
    {
        $this->parsed = $this->ft->parse();
        $this->setDefaultPlotarea();
        $this->createCanvas();
        $this->transformer = $this->canvas->getTransformer();
    }

    /**
     * creates canvas
     */
    protected function createCanvas(): void
    {
        $this->canvas = Plotter::make(
            canvasSize: $this->canvasSize,
            viewport: $this->viewport,
            plotarea: $this->plotarea,
            backgroundColor: $this->canvasBackgroundColor,
        );
    }

    /**
     * plots grids
     */
    protected function plotGrids(): void
    {
        if (!$this->showGrid) {
            return;
        }
        $this->canvas->plotGridHorizon( // @phpstan-ignore-line
            width: $this->gridWidth,
            color: $this->gridColor,
        );
        $this->canvas->plotGridVertical( // @phpstan-ignore-line
            width: $this->gridWidth,
            color: $this->gridColor,
        );
        list($offsetX, $offsetY) = $this->plotarea['offset'];
        $coords = $this->transformer->getCoords([[1, 0], [1, 1]]);
        $this->canvas->drawLine(
            $coords[0][0] + $offsetX,
            $coords[0][1] + $offsetY,
            $coords[1][0] + $offsetX,
            $coords[1][1] + $offsetY,
            $this->gridWidth,
            $this->gridColor,
        );
    }

    /**
     * plots axis
     */
    protected function plotAxis(): void
    {
        list($offsetX, $offsetY) = $this->plotarea['offset'];
        $coords = $this->transformer->getCoords([[0, 0], [1, 0], [0, 1]]);
        // x-axis
        $this->canvas->drawLine(
            x1: $coords[0][0] + $offsetX,
            y1: $coords[0][1] + $offsetY,
            x2: $coords[1][0] + $offsetX,
            y2: $coords[1][1] + $offsetY,
            width: $this->axisWidth,
            color: $this->axisColor,
        );
        // y-axis
        $this->canvas->drawLine(
            x1: $coords[0][0] + $offsetX,
            y1: $coords[0][1] + $offsetY,
            x2: $coords[2][0] + $offsetX,
            y2: $coords[2][1] + $offsetY,
            width: $this->axisWidth,
            color: $this->axisColor,
        );
    }

    /**
     * plots scales
     */
    protected function plotScales(): void
    {
        $this->canvas->plotScaleX( // @phpstan-ignore-line
            interval: 0.2,
            width: $this->scaleWidth,
            length: $this->scaleLength * 2,
            color: $this->scaleColor,
        );
        $this->canvas->plotScaleY( // @phpstan-ignore-line
            interval: 0.2,
            width: $this->scaleWidth,
            length: $this->scaleLength * 2,
            color: $this->scaleColor,
        );
        list($offsetX, $offsetY) = $this->plotarea['offset'];
        $i = 0;
        while ($i <= 1) {
            $points = $this->transformer->getCoords([
                [$i, 0],    // x-axis
                [0, $i],    // y-axis
            ]);
            // x-axis
            $this->canvas->drawText(
                text: (string) $i,
                x: $points[0][0] + $offsetX,
                y: $points[0][1] + $offsetY + 8,
                fontSize: $this->scaleFontSize,
                fontPath: $this->scaleFontPath,
                fontColor: $this->scaleFontColor,
                align: 'center',
                valign: 'top',
            );
            // y-axis
            $this->canvas->drawText(
                text: (string) $i,
                x: $points[1][0] + $offsetX - 8,
                y: $points[1][1] + $offsetY,
                fontSize: $this->scaleFontSize,
                fontPath: $this->scaleFontPath,
                fontColor: $this->scaleFontColor,
                align: 'right',
                valign: 'middle',
            );
            $i += 0.2;
        }
    }

    /**
     * plots complete equality line
     */
    protected function plotCompleteEqualityLine(): void
    {
        // @phpstan-ignore-next-line
        $this->canvas->plotLine(
            x1: 0,
            y1: 0,
            x2: 1,
            y2: 1,
            width: $this->completeEqualityLineWidth,
            color: $this->completeEqualityLineColor,
            dash: $this->completeEqualityLineDash,
        );
    }

    /**
     * plots Lorenz Curve
     */
    protected function plotLorenzCurve(): void
    {
        $points = $this->getPoints();
        $count = count($points);
        $points[-1] = [0, 0];
        if (count($points) > 2) {
            $this->canvas->plotPolygon( // @phpstan-ignore-line
                points: $points,
                backgroundColor: $this->lorenzCurveBackgroundColor,
                borderWidth: 0,
                borderColor: null,
            );
        }
        $this->canvas->plotPerfectCircle( // @phpstan-ignore-line
            x: 0,
            y: 0,
            radius: 4,
            backgroundColor: $this->lorenzCurveColor,
            borderWidth: 0,
        );
        for ($i = 0; $i < $count; $i++) {
            $this->canvas->plotLine( // @phpstan-ignore-line
                x1: $points[$i - 1][0],
                y1: $points[$i - 1][1],
                x2: $points[$i][0],
                y2: $points[$i][1],
                width: $this->lorenzCurveWidth,
                color: $this->lorenzCurveColor,
            );
            $this->canvas->plotPerfectCircle( // @phpstan-ignore-line
                x: $points[$i][0],
                y: $points[$i][1],
                radius: 4,
                backgroundColor: $this->lorenzCurveColor,
                borderWidth: 0,
            );
        }
    }

    /**
     * plots label of X
     * @return  self
     */
    private function plotLabelX()
    {
        if (!$this->labelX) {
            return $this;
        }
        $baseY = (int) $this->plotarea['offset'][1]
               + (int) $this->plotarea['height'];
        $x = (int) $this->canvasSize['width'] / 2;
        $y = (int) (
            $baseY
            + ($this->canvasSize['height'] - $this->plotarea['height'])
            / 3
        );
        $this->canvas->drawText(
            text: (string) $this->labelX,
            x: $x + $this->labelXOffsetX,
            y: $y + $this->labelXOffsetY,
            fontSize: $this->fontSize,
            fontPath: $this->fontPath,
            fontColor: $this->fontColor,
            align: 'center',
            valign: 'bottom',
        );
        return $this;
    }

    /**
     * plots label of Y
     * @return  self
     */
    private function plotLabelY()
    {
        if (!$this->labelY) {
            return $this;
        }
        $width = $this->canvasSize['height'];
        $height = (int) round(
            ($this->canvasSize['width'] - $this->plotarea['width']) / 2
        );
        $x = (int) round($width / 2);
        $y = (int) round($height * 2 / 5);
        $this->canvas->drawText(
            text: (string) $this->labelY,
            x: $x,
            y: $y,
            fontSize: $this->fontSize,
            fontPath: $this->fontPath,
            fontColor: $this->fontColor,
            align: 'center',
            valign: 'middle',
            angle: 90,
            offsetX: $this->labelYOffsetX,
            offsetY: $this->labelYOffsetY,
            rotateAlign: 'left',
            rotateValign: 'bottom',
        );
        return $this;
    }

    /**
     * plots caption
     * @return  self
     */
    private function plotCaption()
    {
        if (!$this->caption) {
            return $this;
        }
        $x = (int) round($this->canvasSize['width'] / 2);
        $y = (int) round(
            ($this->canvasSize['height'] - $this->plotarea['height']) / 3
        );
        $this->canvas->drawText(
            (string) $this->caption,
            $x + $this->captionOffsetX,
            $y + $this->captionOffsetY,
            fontSize: $this->fontSize,
            fontPath: $this->fontPath,
            fontColor: $this->fontColor,
            align: 'center',
            valign: 'bottom',
        );
        return $this;
    }

    /**
     * creates and saves the image
     *
     * @param   string  $path
     * @return  self
     */
    public function create(string $path)
    {
        $this->setProps();
        $this->plotGrids();
        $this->plotScales();
        $this->plotLorenzCurve();
        $this->plotCompleteEqualityLine();
        $this->plotAxis();
        $this->plotLabelX();
        $this->plotLabelY();
        $this->plotCaption();
        $this->canvas->save($path);
        return $this;
    }
}
