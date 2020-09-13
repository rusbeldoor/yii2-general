<?php

namespace rusbeldoor\yii2General\widgets;

use rusbeldoor\yii2General\common\helpers\BaseUI;

/**
 *
 */
class AddEditForm extends \yii\bootstrap4\ActiveForm
{
    public $layout = 'horizontal';

    /**
     * @param $model
     * @return string
     */
    public function buttons($model)
    { return BaseUI::buttonsForAddEditForm($model);}
}
