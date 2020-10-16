<?php

namespace rusbeldoor\yii2General\common\models;

/**
 * User_subscription_key (ActiveQuery)
 *
 * @see UserSubscriptionKey
 */
class UserSubscriptionKeyQuery extends \rusbeldoor\yii2General\models\ActiveQuery
{
    /**
     * ...
     *
     * @return UserSubscriptionKeyQuery
     */
    public function aliases($aliases)
    { return $this->andWhere("active=1"); }
}
