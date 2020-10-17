<?php

namespace rusbeldoor\yii2General\modules\subscriptions\controllers;

use rusbeldoor\yii2General\common\models\UserSubscriptionChannel;
use rusbeldoor\yii2General\common\models\UserSubscriptionKey;
use rusbeldoor\yii2General\helpers\ArrayHelper;
use yii;

use rusbeldoor\yii2General\common\models\UserSubscription;
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
        if ($hash != $subscriptionHash) { return AppHelper::redirectWitchFlash('/', 'danger', 'Доступ запрещён.'); }

        $result = [
            'id' => '', // Ид
            'alias' => '', // Алиас
            'name' => '', // Название
            'childKeys' => [], // Дочерние ключи
            'channels' => [], // Каналы
        ];;

        // Ключи
        $userSubscriptionKeys = UserSubscriptionKey::find()->allChilds($getKeyAlias)->all();
        $userSubscriptionKeysById = ArrayHelper::arrayByField($userSubscriptionKeys, 'id');
        $userSubscriptionKeysByAlias = ArrayHelper::arrayByField($userSubscriptionKeys, 'alias');
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
                        'id' => $userSubscriptionKeysByAlias[$currentKeyAlias]->id, // Ид
                        'name' => $userSubscriptionKeysByAlias[$currentKeyAlias]->name, // Название
                        'alias' => $userSubscriptionKeysByAlias[$currentKeyAlias]->alias, // Название
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

        $post = yii::$app->request->post();
        if (!isset($post['userId'])) { return AppHelper::redirectWitchFlash('/', 'danger', 'Не указан обязательный параметр userId.'); }
        if (!isset($post['keyId'])) { return AppHelper::redirectWitchFlash('/', 'danger', 'Не указан обязательный параметр keyId.'); }
        if (!isset($post['channelId'])) { return AppHelper::redirectWitchFlash('/', 'danger', 'Не указан обязательный параметр channelId.'); }
        if (!isset($post['hash'])) { return AppHelper::redirectWitchFlash('/', 'danger', 'Не указан обязательный параметр hash.'); }
        if (!isset($post['redirectUrl'])) { return AppHelper::redirectWitchFlash('/', 'danger', 'Не указан обязательный параметр redirectUrl.'); }

        // Проверяем хэш
        $subscriptionHash = hash('sha256', $post['userId'] . $post['keyId'] . $post['channelId']);
        $subscriptionHash = hash('sha256', $subscriptionHash . $this->module->salt);
        if ($post['hash'] != $subscriptionHash) { return AppHelper::redirectWitchFlash('/', 'danger', 'Доступ запрещён.'); }

        // Удаляем подписку
        UserSubscription::deleteAll(['user_id' => $post['userId'], 'key_id' => $post['keyId'], 'channel_id' => $post['channelId']]);

        // Возвращаемся на список подписок
        AppHelper::redirectWitchFlash($post['redirectUrl'], 'succes', 'Вы успешно отписались.');
    }
}
