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
     * @param $userId int
     * @return UserSubscriptionQuery
     */
    public function userId($userId)
    { return $this->andWhere("user_id=:userId", [':userId' => $userId]); }

    /**
     * ...
     *
     * @param $keyId int
     * @return UserSubscriptionQuery
     */
    public function keyId($keyId)
    { return $this->andWhere("key_id=:key_id", [':key_id' => $keyId]); }

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
     * @param $channelId int
     * @return UserSubscriptionQuery
     */
    public function channelId($channelId)
    { return $this->andWhere("channel_id=:channelId", [':channelId' => $channelId]); }

    /**
     * ...
     *
     * @param $channelsIds array
     * @return UserSubscriptionQuery
     */
    public function channelsIds($channelsIds)
    {
        if (!count($channelsIds)) { return $this; }
        return $this->andWhere("channel_id IN (" . implode(',', $channelsIds) . ")");
    }
}
