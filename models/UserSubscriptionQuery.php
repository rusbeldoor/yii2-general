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

    /**
     * ...
     *
     * @param int $keyId
     * @return UserSubscriptionQuery
     */
    public function keyId($keyId)
    { return $this->andWhere("key_id=:key_id", [':key_id' => $keyId]); }

    /**
     * ...
     *
     * @param array $keysIds
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
     * @param int $channelId
     * @return UserSubscriptionQuery
     */
    public function channelId($channelId)
    { return $this->andWhere("channel_id=:channelId", [':channelId' => $channelId]); }

    /**
     * ...
     *
     * @param array $channelsIds
     * @return UserSubscriptionQuery
     */
    public function channelsIds($channelsIds)
    {
        if (!count($channelsIds)) { return $this; }
        return $this->andWhere("channel_id IN (" . implode(',', $channelsIds) . ")");
    }
}
