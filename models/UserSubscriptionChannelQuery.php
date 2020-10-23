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
     * @param $aliases null|string|array
     * @return UserSubscriptionChannelQuery
     */
    public function aliases($aliases)
    {
        if ($aliases === null) { return $this; }
        if (!is_array($aliases)) { $aliases = [$aliases]; }
        return $this->andWhere("alias IN ('" . implode("','", $aliases) . "')");
    }
}
