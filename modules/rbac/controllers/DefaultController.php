<?php
namespace rusbeldoor\yii2General\modules\rbac\controllers;

use Yii;

/**
 * Default controller for the `rbac` module
 */
class DefaultController extends \backend\components\Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    { Yii::$app->request->redirect('/administrator'); }
}
