<?php

namespace rusbeldoor\yii2General\helpers;

class DatetimeHelper
{
    const SECONDS_IN_MINUTE = 60;
    const SECONDS_IN_HOUR = 60 * self::SECONDS_IN_MINUTE;
    const SECONDS_IN_DAY = 24 * self::SECONDS_IN_HOUR;
    const SECONDS_IN_WEEK = 7 * self::SECONDS_IN_DAY;
    const SECONDS_IN_YEAR = 365 * self::SECONDS_IN_DAY;

    /** Дополнение реализации стандартной функции date */
    public static function date(string $format, int|string $value): ?string
    {
        if (is_numeric($value)) { return (($value > 0) ? date($format, $value) : '-'); }
        if (is_string($value)) { return ((!empty($value)) ? date($format, strtotime($value)) : '-'); }
        return null;
    }

    /** Пример: 2020-11-29 18:42:01 */
    public static function formatYearMonthDayHourMinuteSecond(int|string $value): string
    { return self::date('Y-m-d H:i:s', $value); }

    /** Пример: 18:42 29.11.2020 */
    public static function formatHourMinuteDayMonthYear(int|string $value): string
    { return self::date('H:i d.m.Y', $value); }

    /** Пример: 29.11.2020 18:42 */
    public static function formatDayMonthYearHourMinute(int|string $value): string
    { return self::date('d.m.Y H:i', $value); }

    /** Пример: 18:42:01 29.11.2020 */
    public static function formatHourMinuteSecondDayMonthYear(int|string $value): string
    { return self::date('H:i:s d.m.Y', $value); }

    /** Пример: 18:42:01 29.11.2020 */
    public static function formatDayMonthYearHourMinuteSecond(int|string $value): string
    { return self::date('d.m.Y H:i:s', $value); }

    /** Пример: 18:42 */
    public static function formatHourMinute(int|string $value): string
    { return self::date('H:i', $value); }

    /** Пример: 18:42:01 */
    public static function formatHourMinuteSecond(int|string $value): string
    { return self::date('H:i:s', $value); }

    /** Пример: 29.11.2020 */
    public static function formatDayMonthYear(int|string $value): string
    { return self::date('d.m.Y', $value); }

    /** Пример: 1 520 сек. */
    public static function formatCountSecond(int|string $value, string $end = '&nbsp;сек.'): string
    { return number_format((int)$value, 0, '', ' ') . $end; }

    /** Пример: 1 519 мин. */
    public static function formatCountMinute(int|string $value, string $end = '&nbsp;мин.'): string
    { return number_format((int)((int)$value / self::SECONDS_IN_MINUTE), 0, '', ' ') . $end; }

    /** Пример: 1 518 час. */
    public static function formatCountHour(int|string $value, string $end = '&nbsp;час.'): string
    { return number_format((int)((int)$value / self::SECONDS_IN_HOUR), 0, '', ' ') . $end; }

    /** Пример: 1 дн. */
    public static function formatCountDay(int|string $value, string $end = '&nbsp;дн.'): string
    { return number_format((int)((int)$value / self::SECONDS_IN_DAY), 0, '', ' ') . $end; }

    /**
     * Пример: 1 519 мин. 20 сек.
     * Пример: 1 519 мин.
     * Пример: 20 сек.
     */
    public static function formatCountMinuteSecond(int|string $value, string $separator = ' ', bool $showZeroValues = true, string $endMin = '&nbsp;мин.', string $endSec = '&nbsp;сек.'): string
    {
        $value = (int)$value;
        $seconds = $value % 60;
        $minutesSeconds = $value - $seconds;
        $elems = [];
        if ($showZeroValues || $minutesSeconds) { $elems[] = self::formatCountMinute($minutesSeconds, $endMin); }
        if ($showZeroValues || !count($elems) || $seconds) { $elems[] = self::formatCountSecond($seconds, $endSec); }
        return implode($separator, $elems);
    }

    /** Пример: 19:20 */
    public static function formatColonHourMinuteSecond(int|string $value): string
    {
        $value = (int)$value;
        $hoursSeconds = (int)($value / self::SECONDS_IN_HOUR) * self::SECONDS_IN_HOUR;
        $minutesSeconds = $value % self::SECONDS_IN_HOUR;
        $seconds = $value % self::SECONDS_IN_MINUTE;
        $elems = [];
        $elems[] = (((int)($hoursSeconds / self::SECONDS_IN_HOUR) < 10) ? '0' : '') . self::formatCountHour($hoursSeconds, '');
        $elems[] = (((int)($minutesSeconds / self::SECONDS_IN_MINUTE) < 10) ? '0' : '') . self::formatCountMinute($minutesSeconds, '');
        $elems[] = (($seconds < 10) ? '0' : '') . self::formatCountSecond($seconds, '');
        return implode(':', $elems);
    }

    /**
     * Пример:  28 час. 42 мин. 20 сек.
     * Пример:  28 час. 42 мин.
     * Пример:  28 час.
     * Пример:  42 мин. 20 сек.
     * Пример:  42 мин.
     * Пример:  20 сек.
     */
    public static function formatCountHourMinuteSecond(int|string $value, string $separator = ' ', bool $showZeroValues = true): string
    {
        $value = (int)$value;
        $seconds = $value % self::SECONDS_IN_MINUTE;
        $hoursSeconds = (int)($value / self::SECONDS_IN_HOUR) * self::SECONDS_IN_HOUR;
        $minutesSeconds = $value - $hoursSeconds - $seconds;
        $elems = [];
        if ($showZeroValues || $hoursSeconds) { $elems[] = self::formatCountHour($hoursSeconds); }
        if ($showZeroValues || $minutesSeconds) { $elems[] = self::formatCountMinute($minutesSeconds); }
        if ($showZeroValues || !count($elems) || $seconds) { $elems[] = self::formatCountSecond($seconds); }
        return implode($separator, $elems);
    }

    /** Пример: 1 дн. 28 час. 42 мин. 20 сек. */
    public static function formatCountDayHourMinuteSecond(int|string $value, string $separator = ' ', bool $showZeroValues = true): string
    {
        $value = (int)$value;
        $daysSeconds = (int)($value / self::SECONDS_IN_DAY) * self::SECONDS_IN_DAY;
        $value -= $daysSeconds;
        $hoursSeconds = (int)($value / self::SECONDS_IN_HOUR) * self::SECONDS_IN_HOUR;
        $value -= $hoursSeconds;
        $minutesSeconds = (int)($value / self::SECONDS_IN_MINUTE) * self::SECONDS_IN_MINUTE;
        $seconds = $value - $minutesSeconds;

        $elems = [];
        if ($showZeroValues || $daysSeconds) { $elems[] = self::formatCountDay($daysSeconds); }
        if ($showZeroValues || $hoursSeconds) { $elems[] = self::formatCountHour($hoursSeconds); }
        if ($showZeroValues || $minutesSeconds) { $elems[] = self::formatCountMinute($minutesSeconds); }
        if ($showZeroValues || !count($elems) || $seconds) { $elems[] = self::formatCountSecond($seconds); }
        return implode($separator, $elems);
    }

    /** Получить timestamp по дате времени и временной зоне */
    public static function getTimestampByDateTimeAndTimezone(string $datetime, string $timezone): int
    {
        $datetime = explode(' ', $datetime);
        // Если количество полученных элементов не соответствует двум
        if (count($datetime) !== 2) { return -1; }
        $date = $datetime[0];
        $time = $datetime[1];
        $date = explode('-', $date);
        $time = explode(':', $time);
        // Если количество полученных элементов не соответствует двум
        if ((count($date) !== 3) || (count($time) !== 3)) { return -1; }

        $classDateTime = new DateTime();
        $classDateTime->setTimezone(new DateTimeZone($timezone));
        $classDateTime->setDate((int)$date[0], (int)$date[1], (int)$date[2]);
        $classDateTime->setTime((int)$time[0], (int)$time[1], (int)$time[2]);
        return $classDateTime->getTimestamp();
    }

    /** Получить начало */
    public static function getStartTime(int $time, int $dec, ?int $addCount = null): int
    { return ($time - ($time % $dec)) + ($addCount * $dec); }

    /** Получить начала минуты */
    public static function getStartTimeMinute(int $time, ?int $addCount = null): int
    { return self::getStartTime($time, self::SECONDS_IN_MINUTE, $addCount); }

    /** Получить начала часа */
    public static function getStartTimeHour(int $time, ?int $addCount = null): int
    { return self::getStartTime($time, self::SECONDS_IN_HOUR, $addCount); }

    /** Получить начала дня */
    public static function getStartTimeDay(int $time, ?int $addCount = null): int
    { return self::getStartTime($time, self::SECONDS_IN_DAY, $addCount); }

    /** Получить начала недели */
    public static function getStartTimeWeek(int $time, ?int $addCount = null): int
    { return self::getStartTime($time, self::SECONDS_IN_WEEK, $addCount); }

    /** Получить начала недели */
    public static function getStartTimeMonth(int $time, ?int $addCount = null): int
    {
        $time = strtotime(date('Y-m-01 00:00:00', $time));
        if ($addCount) { $time = strtotime((($addCount > 0) ? '+' : '') . $addCount . ' month', $time); }
        return $time;
    }

    /** Преобразование даты и времени в timestamp */
    public static function userDateTimeToTimestamp(string $datetime, ?int $default = -1): ?int
    {
        if ($datetime == '__.__.____ __:__') { $datetime = ''; } // TODO Убрать все проверки на "__.__.____ __:__" при пользовании этим хелпером
        if (trim($datetime)) {
            list($date, $time) = explode(' ', $datetime);
            $date = explode('.', $date);
            $time = explode(':', $time);
            $result = mktime((int)@$time[0], (int)@$time[1], 0, (int)@$date[1], (int)@$date[0], (int)@$date[2]);
            if ($result !== false) { return $result; }
        }
        return $default;
    }
}