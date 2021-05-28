<?php

namespace rusbeldoor\yii2General\helpers;

use yii;

class UserSubscriptionHelper
{
    /**
     * Хэш
     *
     * @param int $userId
     * @param array $params
     * @return string
     */
    public static function hash($userId, $params)
    {
        return hash(
            'sha256',
            hash(
                'sha256',
                $userId
                . ((isset($params['platform'])) ? $params['platform'] : '')
                . ((isset($params['key'])) ? $params['key'] : '')
                . ((isset($params['category'])) ? $params['category'] : '')
                . ((isset($params['actions'])) ? $params['actions'] : '')
                . ((isset($params['channels'])) ? $params['channels'] : '')
            )
            . Yii::$app->params['rusbeldoor']['yii2General']['subscriptions']['salt']
        ); }

    /**
     * Ссылка
     *
     * @param int $userId
     * @param array $params
     * @return string
     */
    public static function link($userId, $params)
    {
        return '/subscriptions?userId=' . $userId
            . ((isset($params['platform'])) ? '&platform=' . $params['platform'] : '')
            . ((isset($params['key'])) ? '&key=' . $params['key'] : '')
            . ((isset($params['category'])) ? '&category=' . $params['category'] : '')
            . ((isset($params['actions'])) ? '&actions=' . $params['actions'] : '')
            . ((isset($params['channels'])) ? '&channels=' . $params['channels'] : '')
            . '&hash=' . self::hash($userId, $params);
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