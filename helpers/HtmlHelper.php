<?php

namespace rusbeldoor\yii2General\helpers;

class HtmlHelper extends \yii\bootstrap5\Html
{
    /** Оповещение */
    public static function alert(string $type, string $text, bool $close = false): string
    {
        if ($close) {
            return '<div class="alert alert-' . $type . '  alert-dismissible fade show">' . $text . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        } else {
            return '<div class="alert alert-' . $type . '">' . $text . '</div>';
        }//
    }

    /** Спинер */
    public static function spinner(int $width = 100, int $height = 100, string $color = '000000'): string
    {
        $width1_2 = $width / 2;
        $height1_2 = $height / 2;
        $width1_4 = $width / 4;
        $height1_4 = $height / 4;
        $width1_8 = $width / 8;
        $height1_8 = $height / 8;
        $width3_4 = $width * 3 / 4;
        $height3_4 = $height * 3 / 4;

        return '<div class="spinner" style="width: ' . $width . 'px; height: ' . $height . 'px;"><div class="circle one" style="left: ' . $width1_4 . 'px; top: ' . $height1_4 . 'px; width: ' . $width1_2 . 'px; height: ' . $height1_2 . 'px; border-top-color: #' . $color . ';"></div><div class="circle two" style="top: ' . $width1_8 . 'px; left: ' . $height1_8 . 'px; width: ' . $width3_4 . 'px; height: ' . $height3_4 . 'px; border-top-color: #' . $color . ';"></div><div class="circle three" style="height: ' . $width . 'px; width: ' . $height . 'px; border-top-color: #' . $color . ';"></div></div>';
    }
}