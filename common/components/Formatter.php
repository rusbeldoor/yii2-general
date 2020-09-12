<?php

namespace rusbeldoor\yiiGeneral\common\components;

class Formatter extends \yii\i18n\Formatter
{
    /**
     * Идентификатор
     *
     * @param $value mixed
     * @return string
     */
    public function id($value)
    { return '#' . $value; }
}