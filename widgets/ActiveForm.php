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

    public $layout = self::TYPE_HORIZONTAL;
    public $fieldConfig = [
        'horizontalCssClasses' => [
            'label' => 'col-sm-2',
            'offset' => 'col-sm-offset-2',
            'wrapper' => 'col-sm-4',
        ],
    ];
}
