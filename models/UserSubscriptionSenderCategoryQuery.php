<?php

namespace rusbeldoor\yii2General\models;

/**
 * User_subscription_sender (ActiveQuery)
 *
 * @see UserSubscriptionSenderCategory
 */
class UserSubscriptionSenderCategoryQuery extends ActiveQuery
{
    /**
     * ...
     *
     * @param int $platformId
     * @return UserSubscriptionSenderCategoryQuery
     */
    public function platformId($platformId)
    {
        if ($platformId === false) { return $this; }
        return $this->andWhere("platform_id=:platformId", [':platformId' => $platformId]);
    }
}
