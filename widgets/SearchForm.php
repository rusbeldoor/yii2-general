<?php

namespace rusbeldoor\yii2General\widgets;

use rusbeldoor\yii2General\common\helpers\BaseUI;

/**
 * Форма поиска
 */
class SearchForm extends \yii\bootstrap4\ActiveForm
{
    public $options = [
        'class' => 'panelSearchForm',
        'method' => 'post',
    ];

    public $layout = 'horizontal';

    /**
     * Кнопки
     *
     * @return string
     */
    public function buttons()
    { return BaseUI::buttonsForSearchForm(); }
}
