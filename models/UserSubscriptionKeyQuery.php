<?php

namespace rusbeldoor\yii2General\models;

/**
 * User_subscription_key (ActiveQuery)
 *
 * @see UserSubscriptionKey
 */
class UserSubscriptionKeyQuery extends ActiveQuery
{
    /**
     * ...
     *
     * @param string|null $alias
     * @return UserSubscriptionKeyQuery
     */
    public function allChildren($alias)
    {
        if ($alias === null) { return $this; }
        return $this->andWhere("alias LIKE '$alias%'");
    }
}
