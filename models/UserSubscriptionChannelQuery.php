<?php

namespace rusbeldoor\yii2General\models;

/**
 * User_subscription_channel (ActiveQuery)
 *
 * @see UserSubscriptionChannel
 */
class UserSubscriptionChannelQuery extends ActiveQuery
{
    /**
     * ...
     *
     * @param array|string|null $aliases
     * @return UserSubscriptionChannelQuery
     */
    public function aliases($aliases)
    {
        if ($aliases === null) { return $this; }
        if (!is_array($aliases)) { $aliases = [$aliases]; }
        return $this->andWhere("alias IN ('" . implode("','", $aliases) . "')");
    }
}
