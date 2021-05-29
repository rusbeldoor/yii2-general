<?php

namespace rusbeldoor\yii2General\widgets;

/**
 * ...
 */
//class ActiveForm extends \kartik\form\ActiveForm
class ActiveForm extends \yii\widgets\ActiveForm
{
    const TYPE_VERTICAL = 'vertical';
    const TYPE_HORIZONTAL = 'horizontal';

    public $fieldClass = 'rusbeldoor\yii2General\widgets\ActiveField';
    
    public $type = self::TYPE_HORIZONTAL;
}
