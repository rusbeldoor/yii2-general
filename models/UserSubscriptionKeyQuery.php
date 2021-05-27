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
     * @param int $platformId
     * @return UserSubscriptionKeyQuery
     */
    public function platformId($platformId)
    {
        if ($platformId === false) { return $this; }
        return $this->andWhere("platform_id=:platformId", [':platformId' => $platformId]);
    }

    /**
     * ...
     *
     * @param string|null $alias
     * @return UserSubscriptionKeyQuery
     */
    public function allChildren($alias)
    {
        if (($alias === false) || ($alias === null)) { return $this; }
        return $this->andWhere("alias LIKE '$alias%'");
    }
}
