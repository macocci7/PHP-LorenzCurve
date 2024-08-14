<?php

namespace Macocci7\PhpLorenzCurve\Traits;

trait AttributesTrait
{
    /**
     * @var array<string, int>  $canvasSize
     */
    protected array $canvasSize;

    /**
     * @var array<string, int[]>    $viewport
     */
    protected array $viewport;

    /**
     * @var array<string, int|string|null|int[]>    $plotarea
     */
    protected array $plotarea;

    protected string|null $canvasBackgroundColor;

    protected int $axisWidth;
    protected string $axisColor;
    protected int $scaleWidth;
    protected int $scaleLength;
    protected string $scaleColor;
    protected int $scaleFontSize;
    protected string $scaleFontPath;
    protected string $scaleFontColor;
    protected int $completeEqualityLineWidth;
    protected string $completeEqualityLineColor;
    /**
     * @var int[]   $completeEqualityLineDash
     */
    protected array $completeEqualityLineDash;
    protected int $lorenzCurveWidth;
    protected string $lorenzCurveColor;
    protected string|null $lorenzCurveBackgroundColor;
    protected string $fontPath;
    protected int $fontSize;
    protected string $fontColor;
    protected string $labelX;
    protected int $labelXOffsetX;
    protected int $labelXOffsetY;
    protected string $labelY;
    protected int $labelYOffsetX;
    protected int $labelYOffsetY;
    protected string $caption;
    protected int $captionOffsetX;
    protected int $captionOffsetY;
    /**
     * @var array<string, array<string, string>>    $validConfig
     */
    protected array $validConfig;

    /**
     * returns the canvas size
     *
     * @return  array<string, int>
     */
    public function size()
    {
        return $this->canvasSize;
    }

    /**
     * sets the canvas size
     *
     * @param   int $width
     * @param   int $height
     * @return  self
     * @thrown  \Exception
     */
    public function resize(int $width, int $height)
    {
        if ($width < 1 || $height < 1) {
            throw new \Exception("invalid canvas size ({$width}, {$height}).");
        }
        $this->canvasSize = [
            'width' => $width,
            'height' => $height,
        ];
        return $this;
    }

    /**
     * sets default plotarea
     */
    protected function setDefaultPlotarea(): void
    {
        $canvas = $this->canvasSize;
        $plotarea = $this->plotarea;
        $rateX = 0.8;
        $rateY = 0.7;
        if (!array_key_exists('offset', $plotarea)) {
            $plotarea['offset'] = [
                (int) round(
                    $canvas['width'] * (1 - $rateX) / 2
                ),
                (int) round(
                    $canvas['height'] * (1 - $rateY) / 2
                ),
            ];
        }
        if (!array_key_exists('width', $plotarea)) {
            $plotarea['width'] = (int) round(
                $canvas['width'] * $rateX
            );
        }
        if (!array_key_exists('height', $plotarea)) {
            $plotarea['height'] = (int) round(
                $canvas['height'] * $rateY
            );
        }
        if (!array_key_exists('backgroundColor', $plotarea)) {
            $plotarea['backgroundColor'] = null;
        }
        $this->plotarea = $plotarea;
    }

    /**
     * sets plotarea
     *
     * @param   int[]       $offset = []
     * @param   int         $width = 0
     * @param   int         $height = 0
     * @param   string|null $backgroundColor = null
     * @return  self
     */
    public function plotarea(
        array $offset = [],
        int $width = 0,
        int $height = 0,
        string|null $backgroundColor = null,
    ) {
        if ($offset !== []) {
            $this->plotarea['offset'] = $offset;
        }
        if ($width > 0) {
            $this->plotarea['width'] = $width;
        }
        if ($height > 0) {
            $this->plotarea['height'] = $height;
        }
        if ($this->isColorCode($backgroundColor) || is_null($backgroundColor)) {
            $this->plotarea['backgroundColor'] = $backgroundColor;
        }
        return $this;
    }

    /**
     * sets label of X
     * @param   string  $label
     * @param   int     $offsetX = 0
     * @param   int     $offsetY = 0
     * @return  self
     */
    public function labelX(
        string $label,
        int $offsetX = 0,
        int $offsetY = 0,
    ) {
        $this->labelX = $label;
        $this->labelXOffsetX = $offsetX;
        $this->labelXOffsetY = $offsetY;
        return $this;
    }

    /**
     * sets label of Y
     * @param   string  $label
     * @param   int     $offsetX = 0
     * @param   int     $offsetY = 0
     * @return  self
     */
    public function labelY(
        string $label,
        int $offsetX = 0,
        int $offsetY = 0,
    ) {
        $this->labelY = $label;
        $this->labelYOffsetX = $offsetX;
        $this->labelYOffsetY = $offsetY;
        return $this;
    }

    /**
     * sets caption
     * @param   string  $caption
     * @param   int     $offsetX = 0
     * @param   int     $offsetY = 0
     * @return  self
     */
    public function caption(
        string $caption,
        int $offsetX = 0,
        int $offsetY = 0,
    ) {
        $this->caption = $caption;
        $this->captionOffsetX = $offsetX;
        $this->captionOffsetY = $offsetY;
        return $this;
    }
}
