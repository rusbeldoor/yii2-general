<?php

namespace rusbeldoor\yii2General\models;

/**
 * User_subscription (ActiveQuery)
 *
 * @see UserSubscriptionException
 */
class UserSubscriptionExceptionQuery extends ActiveQuery
{
    /**
     * ...
     *
     * @param int $subscriptionId
     * @return UserSubscriptionExceptionQuery
     */
    public function subscriptionId($subscriptionId)
    { return $this->andWhere("subscription_id=:subscriptionId", [':subscriptionId' => $subscriptionId]); }
}
