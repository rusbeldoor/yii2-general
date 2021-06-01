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
     * @param string $category
     * @param string $senderKey
     * @param string $action
     * @param string $channel
     * @return string
     */
    public static function hash($userId, $platform = '', $category = '', $senderKey = '', $action = '', $channel = '')
    {
        return hash(
            'sha256',
            hash(
                'sha256',
                implode(',', [$userId, $platform, $category, $senderKey, $action, $channel])
            )
            . Yii::$app->params['rusbeldoor']['yii2General']['subscriptions']['salt']
        );
    }

    /**
     * Ссылка
     *
     * @param int $userId
     * @param string $platform
     * @param string $category
     * @param string $senderKey
     * @param string $action
     * @param string $channel
     * @return string
     */
    public static function link($userId, $platform = '', $category = '', $senderKey = '', $action = '', $channel = '')
    {
        return '/subscriptions?userId=' . $userId
            . (($platform) ? '&platforms=' . $platform : '')
            . (($category) ? '&category=' . $category : '')
            . (($senderKey) ? '&senderKeys=' . $senderKey : '')
            . (($action) ? '&actions=' . $action : '')
            . (($channel) ? '&channels=' . $channel : '')
            . '&hash=' . self::hash($userId, $platform, $category, $senderKey, $action, $channel);
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