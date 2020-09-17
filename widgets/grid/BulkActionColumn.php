<?php

namespace rusbeldoor\yii2General\widgets\grid;

/**
 *
 */
class BulkActionColumn extends \yii\grid\CheckboxColumn
{
    // Атрибуты тега th
    public $headerOptions = ['class' => 'bulkactionColumnHeader'];
    // Атрибуты тега td
    public $contentOptions = ['class' => 'bulkactionColumn'];
    // Атрибуты тега button
    public $buttonOptions = ['class' => 'bulkactionColumn-checkbox'];

    public $cssClass = 'check';
}
