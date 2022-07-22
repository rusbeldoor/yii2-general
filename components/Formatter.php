<?php

namespace rusbeldoor\yii2General\components;

use rusbeldoor\yii2General\helpers\DatetimeHelper;

class Formatter extends \yii\i18n\Formatter
{
    /** Ид (идентификатор) */
    public function asId(int|string $value): string
    {
        if ($value === null) { return $this->nullDisplay; }
        return '#' . $value;
    }

    /**
     * 18:42 29.11.2020
     *
     * @param mixed $value
     * @return string
     */
    public function asDatetimeHourMinuteDayMonthYear($value)
    {
        if ($value === null) { return $this->nullDisplay; }
        return DatetimeHelper::formatHourMinuteDayMonthYear($value);
    }

    /**
     * 18:42:01 29.11.2020
     *
     * @param mixed $value
     * @return string
     */
    public function asDatetimeHourMinuteSecondDayMonthYear($value)
    {
        if ($value === null) { return $this->nullDisplay; }
        return DatetimeHelper::formatHourMinuteSecondDayMonthYear($value);
    }

    /**
     * 18:42
     *
     * @param mixed $value
     * @return string
     */
    public function asDatetimeHourMinute($value)
    {
        if ($value === null) { return $this->nullDisplay; }
        return DatetimeHelper::formatHourMinute($value);
    }

    /**
     * 18:42:01
     *
     * @param mixed $value
     * @return string
     */
    public function asDatetimeHourMinuteSecond($value)
    {
        if ($value === null) { return $this->nullDisplay; }
        return DatetimeHelper::formatHourMinuteSecond($value);
    }

    /**
     * 29.11.2020
     *
     * @param mixed $value
     * @return string
     */
    public function asDatetimeDayMonthYear($value)
    {
        if ($value === null) { return $this->nullDisplay; }
        return DatetimeHelper::formatDayMonthYear($value);
    }

    /**
     * Да / Нет
     *
     * @param mixed $value
     * @return string
     */
    public function asYesNo($value)
    {
        if ($value === null) { return $this->nullDisplay; }
        switch ($value) {
            case 1: case true: case '1': return 'Да';
            case 0: case false: case '': case '0': return 'Нет';
            default: return '';
        }
    }

    /**
     * 1 520 сек.
     *
     * @param int|string|null $value
     * @return string
     */
    public function asCountSecond($value)
    {
        if ($value === null) { return $this->nullDisplay; }
        return DatetimeHelper::formatCountSecond($value);
    }

    /**
     * 1 519 мин. 20 сек.
     * 1 519 мин.
     * 20 сек.
     *
     * @param int|string|null $value
     * @return string
     */
    public function asCountMinuteSecond($value)
    {
        if ($value === null) { return $this->nullDisplay; }
        return DatetimeHelper::formatCountMinuteSecond($value, ' ', false);
    }

    /**
     * 1 519 мин. 20 сек.
     * 20 сек.
     *
     * @param int|string|null $value
     * @return string
     */
    public function asCountHourMinuteSecond($value)
    {
        if ($value === null) { return $this->nullDisplay; }
        return DatetimeHelper::formatCountHourMinuteSecond($value, ' ', false);
    }

    /**
     * Статус
     *
     * @param mixed $value
     * @return string
     */
    public function asStatus($value)
    {
        if ($value === null) { return $this->nullDisplay; }
        switch ($value) {
            case 'wait': return 'Ожидает';
            case 'process': return 'Выполняется';
            case 'complete': return 'Выполнено';
            default: return '';
        }
    }
}