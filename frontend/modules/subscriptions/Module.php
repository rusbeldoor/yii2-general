<?php

namespace rusbeldoor\yii2General\frontend\modules\subscriptions;

use yii;
use rusbeldoor\yii2General\helpers\AppHelper;

/**
 * rbac module definition class
 */
class Module extends \frontend\components\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'rusbeldoor\yii2General\frontend\modules\subscriptions\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    { parent::init(); }
}
