<?php

namespace rusbeldoor\yii2General\widgets;

use rusbeldoor\yii2General\helpers\BaseUI;

/**
 * Форма добавления/изменения
 */
class AddOrEditForm extends ActiveForm
{
    /**
     * {@inheritDoc}
     * @return AddOrEditForm
     */
    public static function begin($config = []): AddOrEditForm
    { return parent::begin($config); }

    /**
     * @param mixed $model
     * @return string
     */
    public function buttons($model)
    { return BaseUI::buttonsForAddOrEditForm($model);}
}
