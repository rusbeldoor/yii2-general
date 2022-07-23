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
        }
    }
}