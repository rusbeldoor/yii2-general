<?php

namespace rusbeldoor\yii2General\components;

use yii;

/**
 * Контроллер
 */
class ConsoleController extends \yii\console\Controller
{
    /**
     * Вызов перед экшеном
     *
     * @param $action
     * @return mixed
     */
    public function beforeAction($action)
    {

        return parent::beforeAction($action);
    }

    /**
     * Вызов после экшена
     *
     * @param $action
     * @param $result
     * @return mixed\
     */
    public function afterAction($action, $result)
    {

        return parent::afterAction($action, $result);
    }
}
