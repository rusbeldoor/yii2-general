<?php

namespace rusbeldoor\yii2General\common\models;

/**
 * User_subscription_key (ActiveQuery)
 *
 * @see UserSubscriptionKey
 */
class UserSubscriptionKeyQuery extends \rusbeldoor\yii2General\models\ActiveQuery
{
    /**
     * ...
     *
     * @param $alias string
     * @return UserSubscriptionKeyQuery
     */
    public function allChilds($alias)
    { return $this->andWhere("alias LIKE ':alias%'", [':alias' => $alias]); }
}
