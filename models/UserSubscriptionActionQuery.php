<?php

namespace rusbeldoor\yii2General\models;

/**
 * User_subscription_action (ActiveQuery)
 *
 * @see UserSubscriptionAction
 */
class UserSubscriptionActionQuery extends ActiveQuery
{
    /**
     * ...
     *
     * @param int $platformId
     * @return UserSubscriptionQuery
     */
    public function platformId($platformId)
    { return $this->andWhere("platform_id=:platformId", [':platformId' => $platformId]); }

    /**
     * ...
     *
     * @param string|null $alias
     * @return UserSubscriptionActionQuery
     */
    public function allChildren($alias)
    {
        if ($alias === null) { return $this; }
        return $this->andWhere("alias LIKE '$alias%'");
    }
}
