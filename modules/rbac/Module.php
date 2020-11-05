<?php
namespace rusbeldoor\yii2General\modules\rbac;

use Yii;
use rusbeldoor\yii2General\helpers\AppHelper;

/**
 * rbac module definition class
 */
class Module extends \backend\components\Module
{
    public $controllerNamespace = 'rusbeldoor\yii2General\modules\rbac\controllers';

    public $onlyMigrations = true; // Изменение только через миграции

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        AppHelper::forbiddenExceptionIfNotHavePermission('rusbeldoor-rbac');

        if (isset(Yii::$app->params['rusbeldoor']['yii2General']['rbac']['onlyMigrations'])) {
            $this->onlyMigrations = Yii::$app->params['rusbeldoor']['yii2General']['rbac']['onlyMigrations'];
        }
    }
}
