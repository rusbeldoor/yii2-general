<?php
namespace rusbeldoor\yii2General\widgets;

/**
 * ...
 */
class ActiveForm extends \kartik\form\ActiveForm
{
    /**
     * @var string the default field class name when calling [[field()]] to create a new field.
     * @see fieldConfig
     */
    public $fieldClass = 'rusbeldoor\yii2General\widgets\ActiveField';

    /**
     * @var string form orientation type (for bootstrap styling). Either [[TYPE_VERTICAL]], [[TYPE_HORIZONTAL]], or
     * [[TYPE_INLINE]]. Defaults to [[TYPE_VERTICAL]].
     */
    public $type = self::TYPE_HORIZONTAL;
}
