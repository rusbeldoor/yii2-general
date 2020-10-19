<?php

namespace rusbeldoor\yii2General\helpers;

class SubscriptionHelper
{
    /**
     * Ссылка
     *
     * @param $userId int
     * @param $key string
     * @param $channels string
     * @return string
     */
    public static function link($userId, $key, $channels)
    {
        $hash = hash('sha256', $userId . $key . $channels);
        $hash = hash('sha256', $hash . Yii::app()->params['subscriptionSalt']);
        return Yii::app()->params['quickServiceFrontendUrl'] . '/subscriptions?userId=' . $userId . '&key=' . $key. '&channels=' . $channels . '&hash=' . $hash;
    }
}