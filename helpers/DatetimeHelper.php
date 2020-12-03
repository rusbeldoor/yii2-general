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

    /**
     * 1 520 сек.
     *
     * @param $value int|string
     * @return string
     */
    public static function formatCountSecond($value)
    { return number_format((int)$value, 0, '', ' ') . ' сек.'; }

    /**
     * 1 519 мин.
     *
     * @param $value int|string
     * @return string
     */
    public static function formatCountMinute($value)
    { return number_format((int)((int)$value / 60), 0, '', ' ') . ' мин.'; }

    /**
     * 1 518 час.
     *
     * @param $value int|string
     * @return string
     */
    public static function formatCountHour($value)
    { return number_format((int)((int)$value / 3600), 0, '', ' ') . ' час.'; }

    /**
     * 1 519 мин. 20 сек.
     * 1 519 мин.
     * 20 сек.
     *
     * @param $value int|string
     * @param $separator string
     * @param $showZeroValues bool
     * @return string
     */
    public static function formatCountMinuteSecond($value, $separator = ' ', $showZeroValues = true)
    {
        $value = (int)$value;
        $seconds = $value % 60;
        $minutesSeconds = $value - $seconds;
        $elems = [];
        if ($showZeroValues || $minutesSeconds) { $elems[] = self::formatCountMinute($minutesSeconds); }
        if ($showZeroValues || $seconds) { $elems[] = self::formatCountSecond($seconds); }
        return implode($separator, $elems);
    }

    /**
     * 28 час. 42 мин. 20 сек.
     * 28 час. 42 мин.
     * 28 час.
     * 42 мин. 20 сек.
     * 42 мин.
     * 20 сек.
     *
     * @param $value int|string
     * @param $separator string
     * @param $showZeroValues bool
     * @return string
     */
    public static function formatCountHourMinuteSecond($value, $separator = ' ', $showZeroValues = true)
    {
        $value = (int)$value;
        $seconds = $value % 60;
        $hoursSeconds = (int)($value / 3600) * 3600;
        $minutesSeconds = $value - $hoursSeconds - $seconds;
        $elems = [];
        if ($showZeroValues || $hoursSeconds) { $elems[] = self::formatCountHour($hoursSeconds); }
        if ($showZeroValues || $minutesSeconds) { $elems[] = self::formatCountMinute($minutesSeconds); }
        if ($showZeroValues || $seconds) { $elems[] = self::formatCountSecond($seconds); }
        return implode($separator, $elems);
    }
}