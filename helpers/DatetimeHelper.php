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
     * 2020-11-29 18:42:01
     *
     * @param $value mixed
     * @return string
     */
    public static function formatYearMonthDayHourMinuteSecond($value)
    { return self::date('Y-m-d H:i:s', $value); }

    /**
     * 18:42 29.11.2020
     *
     * @param $value mixed
     * @return string
     */
    public static function formatHourMinuteDayMonthYear($value)
    { return self::date('H:i d.m.Y', $value); }

    /**
     * 18:42:01 29.11.2020
     *
     * @param $value mixed
     * @return string
     */
    public static function formatHourMinuteSecondDayMonthYear($value)
    { return self::date('H:i:s d.m.Y', $value); }

    /**
     * 18:42
     *
     * @param $value mixed
     * @return string
     */
    public static function formatHourMinute($value)
    { return self::date('H:i', $value); }

    /**
     * 18:42:01
     *
     * @param $value mixed
     * @return string
     */
    public static function formatHourMinuteSecond($value)
    { return self::date('H:i:s', $value); }

    /**
     * 29.11.2020
     *
     * @param $value mixed
     * @return string
     */
    public static function formatDayMonthYear($value)
    { return self::date('d.m.Y', $value); }
}