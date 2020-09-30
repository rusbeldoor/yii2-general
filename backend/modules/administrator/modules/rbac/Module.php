<?php

namespace rusbeldoor\yii2General\backend\modules\administrator\modules\rbac;

use yii;

/**
 * rbac module definition class
 */
class Module extends \backend\components\Module
{
    public $onlyMigrations = true;

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'rusbeldoor\yii2General\backend\modules\administrator\modules\rbac\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        if (isset(Yii::$app->params['rusbeldoor']['yii2-general']['rbac']['onlyMigrations'])) {
            $this->onlyMigrations = Yii::$app->params['rusbeldoor']['yii2-general']['rbac']['onlyMigrations'];
        }
    }
}
