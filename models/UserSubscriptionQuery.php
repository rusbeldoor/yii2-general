<?php

namespace rusbeldoor\yii2General\models;

/**
 * User_subscription (ActiveQuery)
 *
 * @see UserSubscription
 */
class UserSubscriptionQuery extends ActiveQuery
{
    /**
     * ...
     *
     * @param int $userId
     * @return UserSubscriptionQuery
     */
    public function userId($userId)
    { return $this->andWhere("user_id=:userId", [':userId' => $userId]); }
}
