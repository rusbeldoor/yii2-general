<?php

namespace rusbeldoor\yii2General\common\models;

/**
 * User_subscription_channel (ActiveQuery)
 *
 * @see UserSubscriptionChannel
 */
class UserSubscriptionChannelQuery extends \rusbeldoor\yii2General\models\ActiveQuery
{
    /**
     * ...
     *
     * @param $aliases string|array
     * @return UserSubscriptionChannelQuery
     */
    public function aliases($aliases)
    {
        if (!is_array($aliases)) { $aliases = [$aliases]; }
        return $this->andWhere("alias IN (:aliases)", [':aliases' => "'" . implode("','", $aliases) . "'"]);
    }
}
