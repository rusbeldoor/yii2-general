<?php

namespace rusbeldoor\yii2General\modules\subscriptions;

use Yii;

/**
 * rbac module definition class
 */
class Module extends \frontend\components\Module
{
    public $controllerNamespace = 'rusbeldoor\yii2General\modules\subscriptions\controllers';

    public $salt = null; // Соль для хэша

    /** {@inheritdoc} */
    public function init()
    { parent::init(); }
}
