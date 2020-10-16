<?php

namespace rusbeldoor\yii2General\modules\cron;

use yii;
use rusbeldoor\yii2General\helpers\AppHelper;

/**
 * rbac module definition class
 */
class Module extends \backend\components\Module
{
    public $controllerNamespace = 'rusbeldoor\yii2General\modules\cron\controllers';

    public $onlyMigrations = true; // Изменение только через миграции

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        AppHelper::forbiddenExceptionIfNotHavePermission('rusbeldoor_cron');

        if (isset(Yii::$app->params['rusbeldoor']['yii2General']['cron']['onlyMigrations'])) {
            $this->onlyMigrations = Yii::$app->params['rusbeldoor']['yii2General']['cron']['onlyMigrations'];
        }
    }
}
