<?php

namespace rusbeldoor\yii2General\models;

/**
 * User_subscription_action (ActiveQuery)
 *
 * @see UserSubscriptionSenderCategoryAction
 */
class UserSubscriptionSenderCategoryActionQuery extends ActiveQuery
{
    /**
     * ...
     *
     * @param int $platformId
     * @return UserSubscriptionSenderCategoryActionQuery
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
     * @return UserSubscriptionSenderCategoryActionQuery
     */
    public function allChildren($alias)
    {
        if (($alias === false) || ($alias === null)) { return $this; }
        return $this->andWhere("alias LIKE '$alias%'");
    }
}
