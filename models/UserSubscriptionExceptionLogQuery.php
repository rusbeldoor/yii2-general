<?php

namespace rusbeldoor\yii2General\models;

/**
 * User_subscription_log (ActiveQuery)
 *
 * @see UserSubscriptionExceptionLog
 */
class UserSubscriptionExceptionLogQuery extends ActiveQuery
{
    /**
     * ...
     *
     * @param int $exceptionId
     * @return UserSubscriptionExceptionLogQuery
     */
    public function exceptionId($exceptionId)
    { return $this->andWhere("exception_id=:exceptionId", [':exceptionId' => $exceptionId]); }

    /**
     * ...
     *
     * @param int $userId
     * @return UserSubscriptionExceptionLogQuery
     */
    public function userId($userId)
    { return $this->andWhere("user_id=:userId", [':userId' => $userId]); }
}
