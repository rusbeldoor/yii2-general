<?php

namespace rusbeldoor\yii2General\backend\modules\administrator\modules\cron;

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
    public $controllerNamespace = 'rusbeldoor\yii2General\backend\modules\administrator\modules\cron\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        AppHelper::forbiddenExceptionIfNotHavePermission('backend_administrator_cron');

        if (isset(Yii::$app->params['rusbeldoor']['yii2General']['cron']['onlyMigrations'])) {
            $this->onlyMigrations = Yii::$app->params['rusbeldoor']['yii2General']['cron']['onlyMigrations'];
        }
    }
}
