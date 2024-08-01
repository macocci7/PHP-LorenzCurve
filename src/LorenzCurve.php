<?php

namespace Macocci7\PhpLorenzCurve;

use Macocci7\PhpFrequencyTable\FrequencyTable;
use Macocci7\PhpLorenzCurve\Helpers\Config;

class LorenzCurve
{
    use Traits\AttributesTrait;
    use Traits\DataTrait;
    use Traits\JudgeTrait;
    use Traits\PlotterTrait;
    use Traits\VisibilityTrait;

    /**
     * constructor
     *
     * @param   array<int|string, int|float>    $data
     */
    public function __construct(array $data = [])
    {
        $this->loadConf();
        $this->ft = new FrequencyTable();
        if (count($data) > 0) {
            $this->setData($data);
        }
    }

    /**
     * loads config
     */
    protected function loadConf(): void
    {
        Config::load();
        foreach (Config::get('props') as $prop => $value) {
            $this->{$prop} = $value;
        }
    }
}
