<?php

namespace rusbeldoor\yii2General\helpers;

use yii;

class UserSubscriptionHelper
{
    /**
     * Хэш
     *
     * @param int $userId
     * @param string $platform
     * @param string $key
     * @param string $channels
     * @param string $actions
     * @return string
     */
    public static function hash($userId, $platform = 1, $key = '', $channels = '', $actions = '')
    { return hash('sha256', hash('sha256', $userId . $platform . $key . $channels . $actions) . Yii::$app->params['rusbeldoor']['yii2General']['subscriptions']['salt']); }

    /**
     * Ссылка
     *
     * @param int $userId
     * @param string $key
     * @param string $channels
     * @param string $action
     * @return string
     */
    public static function link($userId, $platform = '', $key = '', $channels = '', $actions = '')
    {
        return '/subscriptions?userId=' . $userId
            . (($platform) ? '&platform=' . $platform : '')
            . (($key) ? '&key=' . $key : '')
            . (($channels) ? '&channels=' . $channels : '')
            . (($actions) ? '&actions=' . $actions : '')
            . '&hash=' . self::hash($userId, $key, $channels);
    }

    /**
     * Иконка канала
     *
     * @param string $alias
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