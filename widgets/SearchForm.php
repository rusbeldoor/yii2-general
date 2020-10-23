<?php
namespace rusbeldoor\yii2General\widgets;

use rusbeldoor\yii2General\helpers\BaseUI;

/**
 * Форма поиска
 */
class SearchForm extends \rusbeldoor\yii2General\widgets\ActiveForm
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
