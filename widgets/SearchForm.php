<?php

namespace rusbeldoor\yii2General\widgets;

use rusbeldoor\yii2General\common\helpers\BaseUI;

/**
 * Форма поиска
 */
class SearchForm extends \yii\bootstrap4\ActiveForm
{
    public $options = [
        'class' => 'base-filter',
        'method' => 'post',
        //'id' => 'standard-search-form', todo: x
        //'method' => 'post', todo: x
        'layout' => 'horizontal',
    ];

    /**
     * Кнопки
     *
     * @return string
     */
    public function buttons()
    { return BaseUI::buttonsForSearchForm(); }
}
