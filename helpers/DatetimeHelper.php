<?php
namespace rusbeldoor\yii2General\helpers;

class DatetimeHelper
{
    /**
     * Метка времени
     *
     * @param $value mixed
     * @return int
     */
    public static function timestamp($value)
    {
        if (is_int($value)) { return $value; }
        if (is_string($value)) { return strtotime($value); }
        return (int)$value;
    }

    /**
     * Дополнение реализации стандартной функции date
     *
     * @param $format string
     * @param $value mixed
     * @return string
     */
    public static function date($format, $value)
    { return date($format, self::timestamp($value)); }

    /**
     * 18:42 29.11.2020
     *
     * @param $value mixed
     * @return string
     */
    public static function formatHidmY($value)
    { return self::date('H:i d.m.Y', $value); }
}