<?php

namespace rusbeldoor\yii2General\backend\modules\rbac;

use yii;
use rusbeldoor\yii2General\helpers\AppHelper;

/**
 * rbac module definition class
 */
class Module extends \backend\components\Module
{
    public $onlyMigrations = true;

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'rusbeldoor\yii2General\backend\modules\rbac\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        AppHelper::forbiddenExceptionIfNotHavePermission('rusbeldoor_rbac');

        if (isset(Yii::$app->params['rusbeldoor']['yii2General']['rbac']['onlyMigrations'])) {
            $this->onlyMigrations = Yii::$app->params['rusbeldoor']['yii2General']['rbac']['onlyMigrations'];
        }
    }
}
