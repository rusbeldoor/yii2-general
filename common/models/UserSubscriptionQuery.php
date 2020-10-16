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

    /**
     * ...
     *
     * @param $aliases string|array
     * @return UserSubscriptionQuery
     */
    public function keyByAlias($aliases)
    {
        if (!is_array($aliases)) { $aliases = [$aliases]; }

        UserSubscriptionKey::getIdsByAliases($aliases);

        $this->select .= ', ';
        $this->leftJoin = 'LEFT JOIN user_subscription_key AS usk ON ';
        return $this->andWhere("user_id=1", [':user_id' => $userId]);
    }
}
