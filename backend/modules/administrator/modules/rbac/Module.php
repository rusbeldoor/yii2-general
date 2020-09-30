<?php

namespace rusbeldoor\yii2General\backend\modules\administrator\modules\rbac;

/**
 * rbac module definition class
 */
class Module extends \backend\components\Module
{
    public $changeOnlyThroughMigrations = true;

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

        if (isset(Yii::$app->params['rusbeldoor']['yii2-general']['rbac']['changeOnlyThroughMigrations'])) {
            $this->changeOnlyThroughMigrations = Yii::$app->params['rusbeldoor']['yii2-general']['rbac']['changeOnlyThroughMigrations'];
        }
    }
}
