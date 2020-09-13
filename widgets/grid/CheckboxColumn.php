<?php

namespace rusbeldoor\yii2General\widgets\grid;

/**
 *
 */
class CheckboxColumn extends \yii\grid\CheckboxColumn
{
    // Атрибуты тега th
    public $headerOptions = ['class' => 'checkbox-column-header'];
    // Атрибуты тега td
    public $contentOptions = ['class' => 'checkbox-column'];

    public $cssClass = 'check';
}
