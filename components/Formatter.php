<?php

namespace rusbeldoor\yii2General\components;

use rusbeldoor\yii2General\helpers\DatetimeHelper;

class Formatter extends \yii\i18n\Formatter
{
    /**
     * Идентификатор
     *
     * @param $value mixed
     * @return string
     */
    public function asId($value)
    { return '#' . $value; }

    /**
     * 18:42 29.11.2020
     *
     * @param $value mixed
     * @return string
     */
    public function asDatetimeHourMinuteDayMonthYear($value)
    { return DatetimeHelper::formatHourMinuteDayMonthYear($value); }

    /**
     * 18:42:01 29.11.2020
     *
     * @param $value mixed
     * @return string
     */
    public function asDatetimeHourMinuteSecondDayMonthYear($value)
    { return DatetimeHelper::formatHourMinuteSecondDayMonthYear($value); }

    /**
     * 18:42
     *
     * @param $value mixed
     * @return string
     */
    public function asDatetimeHourMinute($value)
    { return DatetimeHelper::formatHourMinute($value); }

    /**
     * 18:42:01
     *
     * @param $value mixed
     * @return string
     */
    public function asDatetimeHourMinuteSecond($value)
    { return DatetimeHelper::formatHourMinuteSecond($value); }

    /**
     * 29.11.2020
     *
     * @param $value mixed
     * @return string
     */
    public function asDatetimeDayMonthYear($value)
    { return DatetimeHelper::formatDayMonthYear($value); }

    /**
     * Да / Нет
     *
     * @param $value mixed
     * @return string
     */
    public function asYesNo($value)
    {
        switch ($value) {
            case 1: case true: case '1': return 'Да';
            case 0: case false: case '': case '0': return 'Нет';
            default: return '';
        }
    }

    /**
     * 1 520 сек.
     *
     * @param $value mixed
     * @return string
     */
    public function asCountSecond($value)
    { return DatetimeHelper::formatCountSecond($value); }

    /**
     * 1 519 мин. 20 сек.
     * 20 сек.
     *
     * @param $value mixed
     * @return string
     */
    public function asCountMinuteSecond($value)
    { return DatetimeHelper::formatCountMinuteSecond($value, ' ', false); }

    /**
     * Статус
     *
     * @param $value mixed
     * @return string
     */
    public function asStatus($value)
    {
        switch ($value) {
            case 'wait': return 'Ожидает';
            case 'process': return 'Выполняется';
            default: return '';
        }
    }
}