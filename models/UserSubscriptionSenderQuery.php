<?php

namespace rusbeldoor\yii2General\models;

/**
 * User_subscription_sender (ActiveQuery)
 *
 * @see UserSubscriptionSender
 */
class UserSubscriptionSenderQuery extends ActiveQuery
{
    /**
     * ...
     *
     * @param int $platformId
     * @return UserSubscriptionSenderQuery
     */
    public function categoryId($platformId)
    {
        if ($categoryId === false) { return $this; }
        return $this->andWhere("category_id=:categoryId", [':categoryId' => $categoryId]);
    }
}
