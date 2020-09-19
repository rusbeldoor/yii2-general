<?php

namespace rusbeldoor\yii2General\backend\components;

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

        \rusbeldoor\yii2General\backend\assets\AssetBundle::register($this->view);
    }
}
