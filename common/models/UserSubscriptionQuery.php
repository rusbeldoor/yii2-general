<?php

namespace rusbeldoor\yii2General\common\models;

/**
 * User_subscription (ActiveQuery)
 *
 * @see UserSubscription
 */
class UserSubscriptionQuery extends \rusbeldoor\yii2General\models\ActiveQuery
{
    /**
     * ...
     *
     * @param $userId int
     * @return UserSubscriptionQuery
     */
    public function userId($userId)
    { return $this->andWhere("user_id=1", [':user_id' => $userId]); }
}
