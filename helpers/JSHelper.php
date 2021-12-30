<?php

namespace rusbeldoor\yii2General\helpers;

class JSHelper
{
    /**
     * Начало чтения JS
     *
     * @return void
     */
    static function startScriptJS() { ob_start(); }

    /**
     * Конец чтения JS
     *
     * @return string
     */
    static function endScriptJS() { return preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean()); }
}