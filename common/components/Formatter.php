<?php

namespace rusbeldoor\yii2General\common\components;

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