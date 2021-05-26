<?php

namespace rusbeldoor\yii2General\widgets;

/**
 * ...
 */
class Widget extends \yii\base\Widget
{
    public $model = null;

    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();
        $model = 1;
    }
}
