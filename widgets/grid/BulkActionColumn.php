<?php

namespace rusbeldoor\yii2General\widgets\grid;

/**
 *
 */
class BulkActionColumn extends \yii\grid\CheckboxColumn
{
    // Атрибуты тега th
    public $headerOptions = ['class' => 'actionColumnHeader BulkActionColumnHeader'];
    // Атрибуты тега td
    public $contentOptions = ['class' => 'actionColumn BulkActionColumn'];

    public $cssClass = 'BulkActionColumnCheckbox';
}
