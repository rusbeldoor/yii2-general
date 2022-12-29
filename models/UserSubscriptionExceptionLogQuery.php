<?php

namespace rusbeldoor\yii2General\models;

/**
 * User_subscription_log (ActiveQuery)
 *
 * @see UserSubscriptionExemptionLog
 */
class UserSubscriptionExemptionLogQuery extends ActiveQuery
{
    /**
     * ...
     *
     * @param int $exceptionId
     * @return UserSubscriptionExemptionLogQuery
     */
    public function exceptionId($exceptionId)
    { return $this->andWhere("exception_id=:exceptionId", [':exceptionId' => $exceptionId]); }

    /**
     * ...
     *
     * @param int $userId
     * @return UserSubscriptionExemptionLogQuery
     */
    public function userId($userId)
    { return $this->andWhere("user_id=:userId", [':userId' => $userId]); }
}
