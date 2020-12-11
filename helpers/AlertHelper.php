<?php

namespace rusbeldoor\yii2General\helpers;

class AlertHelper
{
    /**
     * ...
     *
     * @param $type string
     * @param $text string
     * @param $close bool
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
     * @param $type string
     * @param $text string
     * @return void
     */
    public static function alertText($type, $text)
    {
        return '<span class="text-' . $type . '" style="font-weight: bold;">' . $text . '</span>';
    }
}