<?php

namespace rusbeldoor\yii2General\modules\cron;

use Yii;
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

        AppHelper::forbiddenExceptionIfNotHavePermission('cron');

        // Фикс, на сервере не находит эти пути, указываем вручную
        Yii::$classMap['rusbeldoor\yii2General\widgets\select2'] = '@vendor/rusbeldoor/yii2-general/widgets/Select2.php';
        Yii::$classMap['kartik\select2\select2'] = '@vendor/kartik-v/yii2-widget-select2/src/Select2.php';

        if (isset(Yii::$app->params['rusbeldoor']['yii2General']['cron']['onlyMigrations'])) {
            $this->onlyMigrations = Yii::$app->params['rusbeldoor']['yii2General']['cron']['onlyMigrations'];
        }
    }
}
