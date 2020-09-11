<?php

namespace rusbeldoor\yii2General\common\widgets\grid;

use Yii;
use yii\grid\DataColumn;

class IdColumn extends DataColumn
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