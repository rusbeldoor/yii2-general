<?php

namespace rusbeldoor\yii2General\widgets;

use rusbeldoor\yii2General\helpers\BaseUI;

/**
 * Форма добавления/изменения
 */
class AddEditForm extends ActiveForm
{
    public $layout = 'horizontal';

    /**
     * @param mixed $model
     * @return string
     */
    public function buttons($model)
    { return BaseUI::buttonsForAddEditForm($model);}
}
