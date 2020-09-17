<?php

namespace rusbeldoor\yii2General\widgets\grid;

/**
 *
 */
class bulkActionColumn extends \yii\grid\CheckboxColumn
{
    // Атрибуты тега th
    public $headerOptions = ['class' => 'bulkActionColumnHeader'];
    // Атрибуты тега td
    public $contentOptions = ['class' => 'bulkActionColumn'];
    // Атрибуты тега button
    public $buttonOptions = ['class' => 'bulkActionColumnCheckbox'];

    public $cssClass = 'check';
}
