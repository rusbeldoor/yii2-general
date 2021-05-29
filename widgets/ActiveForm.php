<?php

namespace rusbeldoor\yii2General\widgets;

use yii\helpers\Html;

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

    /**
     * Initializes the widget.
     * This renders the form open tag.
     */
    public function init()
    {
        $css = ["form-{$this->type}"];
        Html::addCssClass($this->options, $css);
        parent::init();
    }
}
