<?php

namespace Macocci7\PhpLorenzCurve\Traits;

trait JudgeTrait
{
    /**
     * judges if the param is number or not
     * @param   mixed   $value
     * @return  bool
     */
    public static function isNumber(mixed $value)
    {
        return is_int($value) || is_float($value);
    }

    /**
     * judges if the param is valid or not
     * @param   mixed  $data
     * @return  bool
     */
    public static function isSettableData(mixed $data)
    {
        if (!is_array($data)) {
            return false;
        }
        if (empty($data)) {
            return false;
        }
        foreach ($data as $value) {
            if (!self::isNumber($value)) {
                return false;
            }
        }
        return true;
    }

    /**
     * judges if the param is in '#rrggbb' format or not
     * @param   mixed  $item
     * @return  bool
     */
    public static function isColorCode(mixed $item): bool
    {
        if (!is_string($item)) {
            return false;
        }
        return preg_match('/^#[A-Fa-f0-9]{3}$|^#[A-Fa-f0-9]{6}$/', $item) ? true : false;
    }
}
