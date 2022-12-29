<?php

namespace rusbeldoor\yii2General\models;

/**
 * User_subscription_log (ActiveQuery)
 *
 * @see UserSubscriptionLog
 */
class UserSubscriptionLogQuery extends ActiveQuery
{
    /**
     * ...
     *
     * @param int $subscriptionId
     * @return UserSubscriptionLogQuery
     */
    public function subscriptionId($subscriptionId)
    { return $this->andWhere("subscription_id=:subscriptionId", [':subscriptionId' => $subscriptionId]); }

    /**
     * ...
     *
     * @param int $userId
     * @return UserSubscriptionExemptionLogQuery
     */
    public function userId($userId)
    { return $this->andWhere("user_id=:userId", [':userId' => $userId]); }
}
