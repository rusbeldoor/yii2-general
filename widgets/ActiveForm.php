<?php

namespace rusbeldoor\yii2General\widgets;

use yii\helpers\Html;

/**
 * ...
 */
class ActiveForm extends \yii\widgets\ActiveForm
{
    const TYPE_VERTICAL = 'vertical';
    const TYPE_HORIZONTAL = 'horizontal';

    public $fieldClass = 'rusbeldoor\yii2General\widgets\ActiveField';

    public $options = ['class' => '111'];
    public $fieldConfig = ['class' => '222'];
}
