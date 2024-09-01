<?php

namespace rusbeldoor\yii2General\widgets;

/** ... */
class ActiveForm extends \yii\bootstrap5\ActiveForm
{
    public $fieldClass = 'rusbeldoor\yii2General\widgets\ActiveField';

    public $layout = self::LAYOUT_FLOATING;
}