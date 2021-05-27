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
        $getPlatform = ((isset($get['platform'])) ? $get['platform'] : ((isset($post['platform'])) ? $post['platform'] : false));
        $getKeyAlias = ((isset($get['key'])) ? $get['key'] : ((isset($post['key'])) ? $post['key'] : false));
        $getChannelsAliases = ((isset($get['channels'])) ? $get['channels'] : ((isset($post['channels'])) ? $post['channels'] : false));
        //$getChannelsAliases = ((isset($get['actions'])) ? $get['actions'] : ((isset($post['actions'])) ? $post['actions'] : null));
        $channelsAliases = (($getChannelsAliases) ? explode(',', $getChannelsAliases) : false);

        // Проверяем хэш
        if ($hash != UserSubscriptionHelper::hash($userId, $getPlatform, $getKeyAlias, $getChannelsAliases)) { return AppHelper::redirectWithFlash('/', 'danger', 'Нарушена целосность запроса.'); }

        /** @var UserSubscriptionKey[] $userSubscriptionKeys Ключи */
        $userSubscriptionKeys = UserSubscriptionKey::find()->platformId($getPlatform)->allChildren($getKeyAlias)->indexBy('id')->active()->all();

        /** @var UserSubscriptionChannel[] $userSubscriptionChannels Каналы */
        $userSubscriptionChannels = UserSubscriptionChannel::find()->aliases($channelsAliases)->active()->indexBy('id')->all();
        $channels = [];
        // Обрабатываем каналы
        foreach ($userSubscriptionChannels as $userSubscriptionChannel) {
            $channels[$userSubscriptionChannel->id] = [
                'id' => $userSubscriptionChannel->id,
                'alias' => $userSubscriptionChannel->alias,
                'name' => $userSubscriptionChannel->name,
                'active' => true,
            ];
        }

        /** @var UserSubscriptionAction[] $userSubscriptionActions Действия */
        $userSubscriptionActions = UserSubscriptionAction::find()->platformId($getPlatform)->active()->indexBy('id')->all();
        $actionsByKeyId = [];
        // Перебираем ключи
        foreach ($userSubscriptionKeys as $userSubscriptionKey) {
            $actionsByKeyId[$userSubscriptionKey->id] = [];

            // Перебираем действия
            foreach ($userSubscriptionActions as $userSubscriptionAction) {
                // Если начало строки соответствует
                if (strpos($userSubscriptionKey->alias, $userSubscriptionAction->part_key_alias) === 0) {
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
        $userSubscriptions = [];
        if (count($userSubscriptionKeys)) {
            $userSubscriptions = UserSubscription::find()
                ->userId($userId)
                ->keysIds(array_keys($userSubscriptionKeys))
                ->with(['exemptions' => function ($query) use($userSubscriptionActions, $userSubscriptionChannels) {
                    $query->andWhere(['action_id' => array_keys($userSubscriptionActions), 'channel_id' => array_keys($userSubscriptionChannels)]);
                }])
                ->orderBy('key_id')
                ->all();
        }

        $result = [];
        // Перебираем подписки
        foreach ($userSubscriptions as $userSubscription) {
            // Подписка
            $result[$userSubscription->id] = [
                'id' => $userSubscription->id,
                'key_id' => $userSubscription->key_id,
                'alias' => $userSubscriptionKeys[$userSubscription->key_id]->alias,
                'name' => $userSubscriptionKeys[$userSubscription->key_id]->name,
                'actions' => $actionsByKeyId[$userSubscription->key_id],
                'channels' => $channels,
                'active' => true,
            ];

            // Обрабатываем исключения
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