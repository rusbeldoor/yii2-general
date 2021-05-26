<?php

namespace rusbeldoor\yii2General\helpers;

class AlertHelper
{
    /**
     * ...
     *
     * @param string $type
     * @param string $text
     * @param bool $close
     * @return void
     */
    public static function alert($type, $text, $close = false)
    {
        if ($close) {
            return '<div class="alert alert-' . $type . '  alert-dismissible fade show">' . $text . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
        } else {
            return '<div class="alert alert-' . $type . '">' . $text . '</div>';
        }
    }

    /**
     * ...
     *
     * @param string $type
     * @param string $text
     * @return void
     */
    public static function alertText($type, $text)
    {
        return '<span class="text-' . $type . '">' . $text . '</span>';
    }
}