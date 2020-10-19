<?php

namespace rusbeldoor\yii2General\helpers;

use Yii;

class SubscriptionHelper
{
    /**
     * Хэш
     *
     * @param $userId int
     * @param $key string
     * @param $channels string
     * @return string
     */
    public static function hash($userId, $key = '', $channels = '')
    { return hash('sha256', hash('sha256', $userId . $key . $channels) . Yii::$app->params['rusbeldoor']['yii2General']['subscriptions']['salt']); }

    /**
     * Ссылка
     *
     * @param $userId int
     * @param $key string
     * @param $channels string
     * @return string
     */
    public static function link($userId, $key = '', $channels = '')
    { return '/subscriptions?userId=' . $userId . (($key) ? '&key=' . $key : '') . (($channels) ? '&channels=' . $channels : '') . '&hash=' . self::hash($userId, $key, $channels); }
}