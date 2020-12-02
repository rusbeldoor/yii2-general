<?php

namespace rusbeldoor\yii2General\helpers;

use Yii;

class UserSubscriptionHelper
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

    /**
     * Иконка канала
     *
     * @param $alias string
     * @return string
     */
    public static function channelIcon($alias)
    {
        switch ($alias) {
            case 'email': $channelIconClass = 'far fa-envelope'; break;
            case 'sms': $channelIconClass = 'fas fa-sms'; break;
            case 'vkontakte': $channelIconClass = 'fab fa-vk'; break;
            case 'odnoklassniki': $channelIconClass = 'fab fa-odnoklassniki'; break;
            case 'facebook': $channelIconClass = 'fab fa-facebook-f'; break;
            case 'instagram': $channelIconClass = 'fab fa-instagram'; break;
            case 'whatsapp': $channelIconClass = 'fab fa-whatsapp'; break;
            case 'viber': $channelIconClass = 'fab fa-viber'; break;
            case 'telegram': $channelIconClass = 'fab fa-telegram-plane'; break;
            default: $channelIconClass = 'far fa-comment-alt';
        }
        return '<i class="' . $channelIconClass . '"></i>';
    }
}