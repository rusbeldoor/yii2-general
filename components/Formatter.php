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
     * 18:42
     *
     * @param $value mixed
     * @return string
     */
    public function asDatetimeHourMinute($value)
    { return DatetimeHelper::formatHourMinute($value); }

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
     * Секунды
     *
     * @param $value mixed
     * @return string
     */
    public function asSeconds($value)
    { return (int)$value . ' сек.'; }

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