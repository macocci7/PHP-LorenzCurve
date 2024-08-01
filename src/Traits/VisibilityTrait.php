<?php

namespace Macocci7\PhpLorenzCurve\Traits;

trait VisibilityTrait
{
    protected bool $showGrid = false;
    protected int $gridWidth = 1;
    protected string $gridColor = '#999999';

    /**
     * setsf attributes of the grid
     *
     * @param   int         $width
     * @param   string|null $color
     * @return  self
     * @thrown  \Exception
     */
    public function grid(int $width, string|null $color = null)
    {
        if ($width < 1) {
            throw new \Exception("width must be more than zero.");
        }
        if (!is_null($color) && !$this->isColorCode($color)) {
            throw new \Exception("specify color code in '#rrggbb' format.");
        }
        $this->showGrid = !is_null($color);
        $this->gridWidth = $width;
        if (!is_null($color)) {
            $this->gridColor = $color;
        }
        return $this;
    }
}
