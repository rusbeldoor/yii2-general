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
     * 18:42 29.11.2020
     *
     * @param $value mixed
     * @return string
     */
    public static function formatHidmY($value)
    { return date('H:i d.m.Y', self::timestamp($value)); }
}