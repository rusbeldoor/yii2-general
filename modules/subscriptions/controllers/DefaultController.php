<?php

namespace rusbeldoor\yii2General\modules\subscriptions\controllers;

use yii;
use rusbeldoor\yii2General\common\models\UserSubscriptionChannel;
use rusbeldoor\yii2General\common\models\UserSubscriptionKey;
use rusbeldoor\yii2General\common\models\UserSubscription;
use rusbeldoor\yii2General\helpers\ArrayHelper;
use rusbeldoor\yii2General\helpers\AppHelper;

/**
 * Управление подписками на рассылки
 */
class DefaultController extends \frontend\components\Controller
{
    /**
     * Подписки на рассылки
     *
     * @param $userId int
     * @param $hash string
     * @return string
     */
    public function actionIndex($userId, $hash)
    {
        $get = yii::$app->request->get();
        $getKeyAlias = ((isset($get['key'])) ? $get['key'] : null);
        $getChannelsAliases = null;
        $channelsAliases = null;
        if (isset($get['channels'])) {
            $getChannelsAliases = $get['channels'];
            $channelsAliases = explode(',', $getChannelsAliases);
        }

        // Проверяем хэш
        $subscriptionHash = hash('sha256', $userId . $getKeyAlias . $getChannelsAliases);
        $subscriptionHash = hash('sha256', $subscriptionHash . $this->module->salt);
        if ($hash != $subscriptionHash) { return AppHelper::redirectWitchFlash('/', 'danger', 'Нарушена целосность запроса.'); }

        $result = [
            'id' => '', // Ид
            'alias' => '', // Алиас
            'name' => '', // Название
            'childKeys' => [], // Дочерние ключи
            'channels' => [], // Каналы
        ];

        // Ключи
        $allUserSubscriptionKeys = UserSubscriptionKey::find()->all();
        $allUserSubscriptionKeysByAlias = ArrayHelper::arrayByField($allUserSubscriptionKeys, 'alias');
        $userSubscriptionKeys = UserSubscriptionKey::find()->allChilds($getKeyAlias)->all();
        $userSubscriptionKeysById = ArrayHelper::arrayByField($userSubscriptionKeys, 'id');
        $userSubscriptionKeysIds = array_keys($userSubscriptionKeysById);

        // Каналы
        $userSubscriptionChannels = UserSubscriptionChannel::find()->aliases($channelsAliases)->all();
        $userSubscriptionChannelsByIds = ArrayHelper::arrayByField($userSubscriptionChannels, 'id');
        $userSubscriptionChannelsIds = array_keys($userSubscriptionChannelsByIds);

        // Подписки
        $userSubscriptions = UserSubscription::find()->userId($userId)->keysIds($userSubscriptionKeysIds)->channelsIds($userSubscriptionChannelsIds)->all();

        // Перебираем подписки
        foreach ($userSubscriptions as $userSubscription) {
            // Получаем состовляющие ключа подписки
            $userSubscriptionKeysAliases = explode(';', $userSubscriptionKeysById[$userSubscription->key_id]->alias);

            // Указатель на массив
            $pointer = &$result;

            // Рассматриваемый ключ
            $currentKeyAlias = '';

            // Перебираем составляющие ключа подписки
            foreach ($userSubscriptionKeysAliases as $userSubscriptionKeyAlias) {
                // Дополняем рассматриваемый ключ
                if ($currentKeyAlias != '') { $currentKeyAlias .= ';'; }
                $currentKeyAlias .= $userSubscriptionKeyAlias;

                // Передвигаем указатель
                $pointer = &$pointer['childKeys'];

                // Если такого ключа еще не встречалось
                if (!isset($pointer[$currentKeyAlias])) {
                    // Добавляем ключ
                    $pointer[$currentKeyAlias] = [
                        'id' => $allUserSubscriptionKeysByAlias[$currentKeyAlias]->id, // Ид
                        'name' => $allUserSubscriptionKeysByAlias[$currentKeyAlias]->name, // Название
                        'alias' => $allUserSubscriptionKeysByAlias[$currentKeyAlias]->alias, // Название
                        'childKeys' => [], // Дочерние ключи
                        'channels' => [], // Каналы
                    ];
                }

                // Передвигаем указатель
                $pointer = &$pointer[$currentKeyAlias];
            }

            // Запоминаем каналы их имена
            $pointer['channels'][] = [
                'id' => $userSubscription->channel_id,
                'alias' => $userSubscriptionChannelsByIds[$userSubscription->channel_id]->alias,
                'name' => $userSubscriptionChannelsByIds[$userSubscription->channel_id]->name,
            ];
        }

        $result = $result['childKeys'];
        return $this->render(
            'subscriptions',
            [
                'userId' => $userId,
                'result' => $result,
            ]
        );
    }

    /**
     * Отписка от подписки
     */
    public function actionUnsubscribe()
    {
        AppHelper::exitIfNotPostRequest();

        // post данные
        $post = yii::$app->request->post();
        if (
            !isset($post['userId'])
            || !isset($post['keyAlias'])
            || !isset($post['channelAlias'])
            || !isset($post['hash'])
            || !isset($post['redirectUrl'])
        ) { return AppHelper::redirectWitchFlash('/', 'danger', 'Не указаны некоторые обязательные post параметры.'); }

        // Проверяем хэш
        $subscriptionHash = hash('sha256', $post['userId'] . $post['keyAlias'] . $post['channelAlias']);
        $subscriptionHash = hash('sha256', $subscriptionHash . $this->module->salt);
        if ($post['hash'] != $subscriptionHash) { return AppHelper::redirectWitchFlash('/', 'danger', 'Нарушена целосность запроса.'); }

        // Ключ
        $userSubscriptionKey = UserSubscriptionKey::find()->alias($post['keyAlias'])->one();
        if (!$userSubscriptionKey) { return AppHelper::redirectWitchFlash('/', 'danger', 'Ключ подписки (' . $post['keyAlias'] . ') не найден.'); }

        // Канал
        $userSubscriptionChannel = UserSubscriptionChannel::find()->alias($post['channelAlias'])->one();
        if (!$userSubscriptionChannel) { return AppHelper::redirectWitchFlash('/', 'danger', 'Канал подписки (#' . $post['channelAlias'] . ') не найден.'); }

        // Удаляем подписку
        UserSubscription::deleteAll(['user_id' => $post['userId'], 'key_id' => $userSubscriptionKey->id, 'channel_id' => $userSubscriptionChannel->id]);

        // Возвращаемся по переданному адресу
        AppHelper::redirectWitchFlash($post['redirectUrl'], 'succes', 'Вы успешно отписались от "' . $userSubscriptionKey->name . '" (' . $userSubscriptionChannel->name . ').');
    }
}