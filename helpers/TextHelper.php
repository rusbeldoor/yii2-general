<?php

namespace rusbeldoor\yii2General\helpers;

class TextHelper
{
    /**
     * Первый символ в верхний регистр
     *
     * @param $text string
     * @return string
     */
    public static function mb_ucfirst($text) {
        $fc = mb_strtoupper(mb_substr($text, 0, 1));
        return $fc . mb_substr($text, 1);
    }
}