<?php

namespace rusbeldoor\yii2General\helpers;

class JSHelper
{
    /**
     * Начало чтения JS
     *
     * @return void
     */
    static function startScript() { ob_start(); }

    /**
     * Конец чтения JS
     *
     * @return string
     */
    static function endScript() { return preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean()); }
}