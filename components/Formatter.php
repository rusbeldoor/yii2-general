<?php

namespace rusbeldoor\yii2General\components;

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