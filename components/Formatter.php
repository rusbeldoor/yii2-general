<?php

namespace rusbeldoor\yii2General\components;

use rusbeldoor\yii2General\helpers\DatetimeHelper;

class Formatter extends \yii\i18n\Formatter
{
    public $nullDisplay = '<span class="not-set">(не задано)</span>';

    /**
     * {@inheritdoc}
     * @param mixed $value
     * @param string $type
     */
    public function format($value, $type): string
    { return (($value === null) ? $this->nullDisplay : parent::format($value, $type)); }

    /** Ид (идентификатор) */
    public function formatId(int|string $value): string
    { return '#' . $value; }

    /** Статус */
    public function formatStatus(string $value): string
    { return match($value) { 'wait' => 'Ожидает', 'process' => 'Выполняется', 'complete' => 'Выполнено' }; }

    /** Да/Нет */
    public function formatYesNo(int|string|bool $value): string
    { return FormatterHelper::yesNo($value); }

    /*** Дата и время ***/

    /** Пример: 18:42 29.11.2020 */
    public function formatHourMinuteDayMonthYear(int|string $value): string
    { return DatetimeHelper::formatHourMinuteDayMonthYear($value); }

    /** Пример: 18:42:01 29.11.2020 */
    public function formatHourMinuteSecondDayMonthYear(int|string $value): string
    { return DatetimeHelper::formatHourMinuteSecondDayMonthYear($value); }

    /** Пример: 29.11.2020 18:42 */
    public function formatDayMonthYearHourMinute(int|string $value): string
    { return DatetimeHelper::formatDayMonthYearHourMinute($value); }

    /** Пример: 29.11.2020 18:42:01 */
    public function formatDayMonthYearHourMinuteSecond(int|string $value): string
    { return DatetimeHelper::formatDayMonthYearHourMinuteSecond($value); }

    /** Пример: 18:42 */
    public function formatHourMinute(int|string $value): string
    { return DatetimeHelper::formatHourMinute($value); }

    /** Пример: 18:42:01 */
    public function formatHourMinuteSecond(int|string $value): string
    { return DatetimeHelper::formatHourMinuteSecond($value); }

    /** Пример: 29.11.2020 */
    public function formatDayMonthYear($value): string
    { return DatetimeHelper::formatDayMonthYear($value); }

    /** Пример: 1 520 сек. */
    public function formatCountSecond(int|string|null $value): string
    { return DatetimeHelper::formatCountSecond($value); }

    /**
     * Пример: 1 519 мин. 20 сек.
     * Пример: 1 519 мин.
     * Пример: 20 сек.
     */
    public function formatCountMinuteSecond($value): string
    { return DatetimeHelper::formatCountMinuteSecond($value, ' ', false); }

    /**
     * Пример: 1 519 мин. 20 сек.
     * Пример: 20 сек.
     */
    public function formatCountHourMinuteSecond(int|string|null $value): string
    { return DatetimeHelper::formatCountHourMinuteSecond($value, ' ', false); }

    /*** Ресурсы ***/

    /** Рубли с иконкой */
    public function formatRubleIcon(int|float $value): string
    { return ResourcesHelper::formatRublesDotIcon($value); }

    /** Количество с указанием штук */
    public function formatCount(int|float $value): string
    { return ResourcesHelper::formatCount($value, postfixType: 'shortString'); }
}