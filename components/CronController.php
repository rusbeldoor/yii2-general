<?php

namespace rusbeldoor\yii2General\components;

/**
 * Контроллер
 */
class CronController extends ConsoleController
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
