<?php

namespace rusbeldoor\yii2General\modules\subscriptions\controllers;

use rusbeldoor\yii2General\models\UserSubscriptionExemption;
use yii;
use common\models\User;
use rusbeldoor\yii2General\models\UserSubscription;
use rusbeldoor\yii2General\models\UserSubscriptionKey;
use rusbeldoor\yii2General\models\UserSubscriptionChannel;
use rusbeldoor\yii2General\helpers\ArrayHelper;
use rusbeldoor\yii2General\helpers\AppHelper;
use rusbeldoor\yii2General\helpers\UserSubscriptionHelper;

/**
 * Управление подписками на рассылки
 */
class DefaultController extends \frontend\components\Controller
{
    /**
     * Подписки на рассылки
     *
     * @param int $userId
     * @param string $hash
     * @return string
     */
    public function actionIndex($userId, $hash)
    {
        $get = Yii::$app->request->get();
        $post = Yii::$app->request->post();
        $getPlatform = ((isset($get['platform'])) ? $get['platform'] : ((isset($post['platform'])) ? $post['platform'] : null));
        $getKeyAlias = ((isset($get['key'])) ? $get['key'] : ((isset($post['key'])) ? $post['key'] : null));
        $getChannelsAliases = ((isset($get['channels'])) ? $get['channels'] : ((isset($post['channels'])) ? $post['channels'] : null));
        //$getChannelsAliases = ((isset($get['actions'])) ? $get['actions'] : ((isset($post['actions'])) ? $post['actions'] : null));
        $channelsAliases = (($getChannelsAliases) ? explode(',', $getChannelsAliases) : null);

        // Проверяем хэш
        // if ($hash != UserSubscriptionHelper::hash($userId, $getKeyAlias, $getChannelsAliases)) { return AppHelper::redirectWithFlash('/', 'danger', 'Нарушена целосность запроса.'); }

        $result = [
            'id' => '', // Ид
            'alias' => '', // Алиас
            'name' => '', // Название
            'childKeys' => [], // Дочерние ключи
            'channels' => [], // Каналы
        ];

        // Ключи
        $allUserSubscriptionKeys = UserSubscriptionKey::find()->indexBy('alias')->active()->all();
        //        $userSubscriptionKeys = UserSubscriptionKey::find()->indexBy('id')->allChildren($getKeyAlias)->all();
        //        $userSubscriptionKeysIds = array_keys($userSubscriptionKeys);

        // Каналы
        $allUserSubscriptionChannels = UserSubscriptionChannel::find()->active()->indexBy('id')->all();

        // Подписки
        $userSubscriptions = UserSubscription::find()
            ->userId($userId)
            ->with(['key' => function ($query) { $query->with('platform'); }, 'exemptions'])
            ->all();

        // Перебираем подписки
        foreach ($userSubscriptions as $userSubscription) {
            // Получаем состовляющие ключа подписки
            $userSubscriptionKeysAliases = explode(';', $userSubscriptionKeys[$userSubscription->key_id]->alias);

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
                        'id' => null, // Ид
                        'alias' => null, // Алиас
                        'name' => null, // Название
                        'childKeys' => [], // Дочерние ключи
                        'channels' => [], // Каналы
                    ];
                }

                // Если ключ известен
                if (isset($allUserSubscriptionKeys[$currentKeyAlias])) {
                    // Заполняем значения
                    if ($pointer[$currentKeyAlias]['id'] === null) { $pointer[$currentKeyAlias]['id'] = $allUserSubscriptionKeys[$currentKeyAlias]->id; }
                    if ($pointer[$currentKeyAlias]['alias'] === null) { $pointer[$currentKeyAlias]['alias'] = $allUserSubscriptionKeys[$currentKeyAlias]->alias; }
                    if ($pointer[$currentKeyAlias]['name'] === null) { $pointer[$currentKeyAlias]['name'] = $allUserSubscriptionKeys[$currentKeyAlias]->name; }
                }

                // Передвигаем указатель
                $pointer = &$pointer[$currentKeyAlias];
            }

            // Запоминаем каналы их имена
            $pointer['channels'][] = [
                'id' => $userSubscription->channel_id,
                'alias' => $allUserSubscriptionChannels[$userSubscription->channel_id]->alias,
                'name' => $allUserSubscriptionChannels[$userSubscription->channel_id]->name,
                'active' => $userSubscription->active,
            ];
        }

        return $this->render('subscriptions', ['userId' => $userId, 'result' => $result['childKeys']]);
    }

    /**
     * Отписка от подписки
     *
     * @return void
     */
    public function actionChange()
    {
        AppHelper::exitIfNotPostRequest();

        // post данные
        $post = Yii::$app->request->post();
        if (
            !isset($post['userId'])
            || !isset($post['keyAlias'])
            || !isset($post['channelAlias'])
            || !isset($post['hash'])
            || !isset($post['active'])
            || !isset($post['redirectUrl'])
        ) { return AppHelper::redirectWithFlash('/', 'danger', 'Не указаны некоторые обязательные post параметры.'); }

        // Проверяем хэш
        if ($post['hash'] != UserSubscriptionHelper::hash($post['userId'], $post['keyAlias'], $post['channelAlias'])) { return AppHelper::redirectWithFlash('/', 'danger', 'Нарушена целосность запроса.'); }

        // Пользователь
        $user = User::find($post['userId'])->one();
        if (!$user) { return AppHelper::redirectWithFlash('/', 'danger', 'Пользователь (#' . $post['userId'] . ') не найден.'); }

        // Ключ
        $userSubscriptionKey = UserSubscriptionKey::find()->alias($post['keyAlias'])->one();
        if (!$userSubscriptionKey) { return AppHelper::redirectWithFlash('/', 'danger', 'Ключ подписки (' . $post['keyAlias'] . ') не найден.'); }

        // Канал
        $userSubscriptionChannel = UserSubscriptionChannel::find()->alias($post['channelAlias'])->one();
        if (!$userSubscriptionChannel) { return AppHelper::redirectWithFlash('/', 'danger', 'Канал подписки (#' . $post['channelAlias'] . ') не найден.'); }

        // Подписка на рассылки
        $userSubscription = UserSubscription::find()->userId($post['userId'])->keyId($userSubscriptionKey->id)->channelId($userSubscriptionChannel->id)->one();
        // Если подписка на рассылки существует
        if ($userSubscription) {
            // Изменяем (активируем или деактивируем) подписку на рассылки
            $userSubscription->active = $post['active'];
            $userSubscription->update();
        } else {
            // Добавляем активную или не активную подписку на рассылки
            $userSubscription = new UserSubscription();
            $userSubscription->key_id = $user->id;
            $userSubscription->key_id = $userSubscriptionKey->id;
            $userSubscription->channel_id = $userSubscriptionChannel->id;
            $userSubscription->active = $post['active'];
            $userSubscription->save();
        }

        // Возвращаемся по переданному адресу
        AppHelper::redirectWithFlash($post['redirectUrl'], 'success', 'Вы ' . (($post['active']) ? 'подписались на' : 'отписались от') . ' "' . $userSubscriptionKey->name . '" (' . $userSubscriptionChannel->name . ').');
    }
}