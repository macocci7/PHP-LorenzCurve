<?php

namespace Macocci7\PhpLorenzCurve;

use Macocci7\PhpFrequencyTable\FrequencyTable;
use Macocci7\PhpLorenzCurve\Helpers\Config;
use Nette\Neon\Neon;

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

    /**
     * set config from specified resource
     * @param   string|mixed[]  $configResource
     * @return  self
     */
    public function config(string|array $configResource)
    {
        if (is_string($configResource)) {
            $conf = $this->configFromFile($configResource);
        } else {
            $conf = $this->configFromArray($configResource);
        }
        foreach ($conf as $key => $value) {
            $this->{$key} = $value;
        }
        return $this;
    }

    /**
     * returns valid config items from specified file
     * @param   string  $path
     * @return  mixed[]
     * @thrown  \Exception
     */
    private function configFromFile(string $path)
    {
        if (strlen($path) === 0) {
            throw new \Exception("Specify valid filename.");
        }
        if (!is_readable($path)) {
            throw new \Exception("Cannot read file $path.");
        }
        $content = Neon::decodeFile($path);
        return $this->configFromArray($content);
    }

    /**
     * returns valid config items from specified array
     * @param   mixed[] $content
     * @return  mixed[]
     * @thrown  \Exception
     */
    private function configFromArray(array $content)
    {
        $conf = [];
        foreach ($this->validConfig as $key => $def) {
            if (array_key_exists($key, $content)) {
                if (Config::isValid($content[$key], $def['type'])) {
                    $conf[$key] = $content[$key];
                } else {
                    $message = $key . " must be type of " . $def['type'] . ".";
                    throw new \Exception($message);
                }
            }
        }
        return $conf;
    }
}
