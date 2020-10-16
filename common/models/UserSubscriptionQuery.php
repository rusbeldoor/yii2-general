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
    { return $this->andWhere("user_id=:userId", [':userId' => $userId]); }

    /**
     * ...
     *
     * @param $keysIds array
     * @return UserSubscriptionQuery
     */
    public function keysIds($keysIds)
    {
        if (!count($keysIds)) { return $this; }
        return $this->andWhere("key_id IN (" . implode(',', $keysIds) . ")");
    }

    /**
     * ...
     *
     * @param $channelsIds array
     * @return UserSubscriptionQuery
     */
    public function channelsIds($channelsIds)
    {
        if (!count($channelsIds)) { return $this; }
        return $this->andWhere("chanel_id IN (" . implode(',', $channelsIds) . ")");
    }
}
