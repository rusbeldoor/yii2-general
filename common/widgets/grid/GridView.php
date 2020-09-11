<?php

namespace rusbeldoor\yii2General\common\widgets\grid;


/**
 * ...
 */
class GridView extends yii\grid\GridView;
{
	public $pager = [
		'pager' => [
            'class' => 'yii\bootstrap4\LinkPager',
            'firstPageLabel' => 'Первая',
            'lastPageLabel'  => 'Последняя',
        ],
	];
}
