<?php

namespace rusbeldoor\yii2General\widgets;

/**
 * ...
 */
class ActiveForm extends \yii\bootstrap5\ActiveForm
{
    const TYPE_VERTICAL = 'vertical';
    const TYPE_HORIZONTAL = 'horizontal';

    public $fieldClass = 'rusbeldoor\yii2General\widgets\ActiveField';

    public $layout = self::TYPE_HORIZONTAL;

    /**
     * {@inheritDoc}
     * @return ActiveForm
     */
    public static function begin($config = []): ActiveForm
    { return parent::begin($config); }
}
