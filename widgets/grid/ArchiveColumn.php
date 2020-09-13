<?php

namespace rusbeldoor\yii2General\widgets\grid;

use yii;

class ArchiveColumn extends \yii\grid\DataColumn
{
    public $headerOptions = ['class' => 'width-1px'];
    public $attribute = 'archive';
    public $label = 'Архив';
	
    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        switch ($model->archive) {
            case 0: case false: case '': case '0': return '<i class="fas fa-archive"></i>';
            case 1: case true: case '1': return '<i class="fas fa-archive"></i>';
            default: return '';
        }
    }
}