<?php

namespace rusbeldoor\yii2General\modules\subscriptions\controllers;

use rusbeldoor\yii2General\models\UserSubscriptionExemption;
use yii;
use common\models\User;
use rusbeldoor\yii2General\models\UserSubscription;
use rusbeldoor\yii2General\models\UserSubscriptionKey;
use rusbeldoor\yii2General\models\UserSubscriptionAction;
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

//        $result = [
//            'id' => '', // Ид
//            'alias' => '', // Алиас
//            'name' => '', // Название
//            'childKeys' => [], // Дочерние ключи
//            'channels' => [], // Каналы
//        ];

        /** @var UserSubscriptionKey[] $userSubscriptionKeys Ключи */
        $userSubscriptionKeys = UserSubscriptionKey::find()->indexBy('id')->active()->all();

        /** @var UserSubscriptionChannel[] $userSubscriptionChannels Каналы */
        $userSubscriptionChannels = UserSubscriptionChannel::find()->active()->indexBy('id')->all();
        $channels = [];
        foreach ($userSubscriptionChannels as $userSubscriptionChannel) {
            $channels[$userSubscriptionChannel->id] = [
                'id' => $userSubscriptionChannel->id,
                'name' => $userSubscriptionChannel->name,
                'active' => true,
            ];
        }

        /** @var UserSubscriptionAction[] $userSubscriptionActions Действия */
        $userSubscriptionActions = UserSubscriptionAction::find()->active()->indexBy('id')->all();
        $actionsByKeyId = [];
        foreach ($userSubscriptionKeys as $userSubscriptionKey) {
            foreach ($userSubscriptionActions as $userSubscriptionAction) {
                // Если начало строки соответствует
                if (strpos($userSubscriptionKey->alias, $userSubscriptionAction->part_key_alias) === 0) {
                    if (!isset($actionsByKeyId[$userSubscriptionKey->id])) { $actionsByKeyId[$userSubscriptionKey->id] = []; }
                    $actionsByKeyId[$userSubscriptionKey->id][$userSubscriptionAction->id] = [
                        'id' => $userSubscriptionAction->id,
                        'name' => $userSubscriptionAction->name,
                        'channels' => $channels,
                        'active' => true,
                    ];
                }
            }
        }


        /** @var UserSubscription[] $userSubscriptions Подписки */
        $userSubscriptions = UserSubscription::find()->userId($userId)->with('exemptions')->orderBy('key_id')->all();

        $result = [];

        foreach ($userSubscriptions as $userSubscription) {
            $result[$userSubscription->id] = [
                'id' => $userSubscription->id,
                'key_id' => $userSubscription->key_id,
                'name' => $userSubscriptionKeys[$userSubscription->key_id]->name,
                'actions' => $actionsByKeyId[$userSubscription->key_id],
                'channels' => $channels,
                'active' => true,
            ];

            foreach ($userSubscription->exemptions as $exemption) {
                if (isset($exemption->action_id)) {
                    if (isset($exemption->channel_id)) {
                        $result[$userSubscription->id]['actions'][$exemption->action_id]['channels'][$exemption->channel_id]['active'] = false;
                    } else {
                        $result[$userSubscription->id]['actions'][$exemption->action_id]['active'] = false;
                    }
                } elseif (isset($exemption->channel_id)) {
                    $result[$userSubscription->id]['channels'][$exemption->channel_id]['active'] = false;
                } else {
                    $result[$userSubscription->id]['active'] = false;
                }
            }
        }


        // Перебираем подписки
//        foreach ($userSubscriptions as $userSubscription) {
//            // Получаем состовляющие ключа подписки
//            $userSubscriptionKeysAliases = explode(';', $userSubscription->key->alias);
//
//            // Указатель на массив
//            $pointer = &$result;
//
//            // Рассматриваемый ключ
//            $currentKeyAlias = '';
//
//            // Перебираем составляющие ключа подписки
//            foreach ($userSubscriptionKeysAliases as $userSubscriptionKeyAlias) {
//                // Дополняем рассматриваемый ключ
//                if ($currentKeyAlias != '') { $currentKeyAlias .= ';'; }
//                $currentKeyAlias .= $userSubscriptionKeyAlias;
//
//                // Передвигаем указатель
//                $pointer = &$pointer['childKeys'];
//
//                // Если такого ключа еще не встречалось
//                if (!isset($pointer[$currentKeyAlias])) {
//                    // Добавляем ключ
//                    $pointer[$currentKeyAlias] = [
//                        'id' => null, // Ид
//                        'alias' => null, // Алиас
//                        'name' => null, // Название
//                        'childKeys' => [], // Дочерние ключи
//                        'channels' => [], // Каналы
//                    ];
//                }
//
//                // Если ключ известен
//                if (isset($userSubscriptionKeys[$currentKeyAlias])) {
//                    // Заполняем значения
//                    if ($pointer[$currentKeyAlias]['id'] === null) { $pointer[$currentKeyAlias]['id'] = $userSubscriptionKeys[$currentKeyAlias]->id; }
//                    if ($pointer[$currentKeyAlias]['alias'] === null) { $pointer[$currentKeyAlias]['alias'] = $userSubscriptionKeys[$currentKeyAlias]->alias; }
//                    if ($pointer[$currentKeyAlias]['name'] === null) { $pointer[$currentKeyAlias]['name'] = $userSubscriptionKeys[$currentKeyAlias]->name; }
//                }
//
//                // Передвигаем указатель
//                $pointer = &$pointer[$currentKeyAlias];
//            }
//
//            // Запоминаем каналы их имена
//            foreach ($userSubscriptionChannels as $userSubscriptionChannel) {
//                $pointer['channels'][] = [
//                    'id' => $userSubscriptionChannel->id,
//                    'alias' => $userSubscriptionChannel->alias,
//                    'name' => $userSubscriptionChannel->name,
//                    'active' => $userSubscriptionChannel->active,
//                ];
//            }
//        }

//        foreach ($userSubscriptions as $userSubscription) {
//
//
//
//            // Запоминаем каналы их имена
//            foreach ($userSubscriptionChannels as $userSubscriptionChannel) {
//                $pointer['channels'][] = [
//                    'id' => $userSubscriptionChannel->id,
//                    'alias' => $userSubscriptionChannel->alias,
//                    'name' => $userSubscriptionChannel->name,
//                    'active' => $userSubscriptionChannel->active,
//                ];
//            }
//        }

        return $this->render('subscriptions', ['userId' => $userId, 'result' => $result]);
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