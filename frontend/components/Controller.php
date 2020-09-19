<?php

namespace rusbeldoor\yii2General\frontend\components;

/**
 * Контроллер
 */
class Controller extends \rusbeldoor\yii2General\common\components\WebController
{
    /**
     * Инициализация
     *
     * @return void
     */
    public function init()
    {
        parent::init();

        \rusbeldoor\yii2General\frontend\assets\AssetBundle::register($this->view);
    }
}
