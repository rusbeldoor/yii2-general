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
    public function adId(int|string $value): string
    { return '#' . $value; }

    /** Статус */
    public function asStatus(string $value): ?string
    { return match($value) {'wait' => 'Ожидает', 'process' => 'Выполняется', 'complete' => 'Выполнено', default => null}; }

    /** Да/Нет */
    public function asYesNo(int|string|bool $value): string
    { return FormatterHelper::yesNo($value); }

    /*** Дата и время ***/

    /** Пример: 18:42 29.11.2020 */
    public function asHourMinuteDayMonthYear(int|string $value): string
    { return DatetimeHelper::formatHourMinuteDayMonthYear($value); }

    /** Пример: 18:42:01 29.11.2020 */
    public function asHourMinuteSecondDayMonthYear(int|string $value): string
    { return DatetimeHelper::formatHourMinuteSecondDayMonthYear($value); }

    /** Пример: 29.11.2020 18:42 */
    public function asDayMonthYearHourMinute(int|string $value): string
    { return DatetimeHelper::formatDayMonthYearHourMinute($value); }

    /** Пример: 29.11.2020 18:42:01 */
    public function asDayMonthYearHourMinuteSecond(int|string $value): string
    { return DatetimeHelper::formatDayMonthYearHourMinuteSecond($value); }

    /** Пример: 18:42 */
    public function asHourMinute(int|string $value): string
    { return DatetimeHelper::formatHourMinute($value); }

    /** Пример: 18:42:01 */
    public function asHourMinuteSecond(int|string $value): string
    { return DatetimeHelper::formatHourMinuteSecond($value); }

    /** Пример: 29.11.2020 */
    public function asDayMonthYear($value): string
    { return DatetimeHelper::formatDayMonthYear($value); }

    /** Пример: 1 520 сек. */
    public function asCountSecond(int|string|null $value): string
    { return DatetimeHelper::formatCountSecond($value); }

    /**
     * Пример: 1 519 мин. 20 сек.
     * Пример: 1 519 мин.
     * Пример: 20 сек.
     */
    public function asCountMinuteSecond($value): string
    { return DatetimeHelper::formatCountMinuteSecond($value, ' ', false); }

    /**
     * Пример: 1 519 мин. 20 сек.
     * Пример: 20 сек.
     */
    public function asCountHourMinuteSecond(int|string|null $value): string
    { return DatetimeHelper::formatCountHourMinuteSecond($value, ' ', false); }

    /*** Ресурсы ***/

    /** Рубли с иконкой */
    public function asRubleIcon(int|float $value): string
    { return ResourcesHelper::formatRublesDotIcon($value); }

    /** Количество с указанием штук */
    public function asCount(int|float $value): string
    { return ResourcesHelper::formatCount($value, postfixType: 'shortString'); }
}