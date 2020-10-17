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
     * @param $alias null|string
     * @return UserSubscriptionKeyQuery
     */
    public function allChilds($alias)
    {
        if ($alias === null) { return $this; }
        return $this->andWhere("alias LIKE '$alias%'");
    }
}