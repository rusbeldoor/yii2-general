<?php

namespace rusbeldoor\yii2General\grid;

use Yii;

class IdColumn extends \yii\grid\DataColumn
{
    public $headerOptions = ['class' => 'width-1px'];
    public $attribute = 'id';
    public $label = 'Ид';
	
    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    { return '#' . $model->id; }
}