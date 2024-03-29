<?php

namespace rusbeldoor\yii2General\widgets;

use rusbeldoor\yii2General\helpers\BaseUI;

/**
 * Форма поиска
 */
class SearchForm extends ActiveForm
{
    public $options = [
        'class' => 'panelSearchForm',
        'method' => 'post',
    ];

    /**
     * {@inheritDoc}
     * @return SearchForm
     */
    public static function begin($config = []): SearchForm
    { return parent::begin($config); }

    /**
     * Кнопки
     *
     * @return string
     */
    public function buttons(): string
    { return BaseUI::buttonsForSearchForm(); }
}
