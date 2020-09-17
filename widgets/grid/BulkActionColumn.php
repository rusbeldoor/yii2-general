<?php

namespace rusbeldoor\yii2General\widgets\grid;

/**
 *
 */
class BulkActionColumn extends \yii\grid\CheckboxColumn
{
    // Атрибуты тега th
    public $headerOptions = ['class' => 'BulkActionColumnHeader'];
    // Атрибуты тега td
    public $contentOptions = ['class' => 'BulkActionColumn'];
    // Атрибуты тега button
    public $buttonOptions = ['class' => 'BulkActionColumnCheckbox'];

    public $cssClass = 'check';
}
