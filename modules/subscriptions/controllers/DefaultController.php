<?php

namespace rusbeldoor\yii2General\modules\subscriptions\controllers;

use rusbeldoor\yii2General\models\UserSubscriptionSenderCategory;
use yii;
use common\models\User;
use rusbeldoor\yii2General\models\UserSubscription;
use rusbeldoor\yii2General\models\UserSubscriptionSender;
use rusbeldoor\yii2General\models\UserSubscriptionSenderCategoryAction;
use rusbeldoor\yii2General\models\UserSubscriptionChannel;
use rusbeldoor\yii2General\models\UserSubscriptionExemption;
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
    public function actionIndex2($userId, $hash)
    {
        // Get Параметры
        $get = Yii::$app->request->get();
        // Post параметры
        $post = Yii::$app->request->post();
        $getParam = function ($param) use($get, $post) {
            return
                // Если существует GET параметр
                ((isset($get[$param])) ?
                    $get[$param]
                    // Если существует Post параметр
                    : ((isset($post[$param])) ? $post[$param] : false));
        };

        // Обработка параметров
        $params = ['platforms' => null, 'category' => null, 'keys' => null, 'channels' => null, 'actions' => null];
        foreach ($params as $key => $param) { $params['key'] = $getParam($key); }

        // Проверка hash`a
        if ($hash != UserSubscriptionHelper::hash($userId, $params)) {
            return AppHelper::redirectWithFlash('/', 'danger', 'Нарушена целосность запроса.');
        }

        /** @var UserSubscriptionSender[] $userSubscriptionKeys Ключи */
        $userSubscriptionKeys = UserSubscriptionSender::find()->categoryId($getPlatform)->allChildren($getKeyAlias)->indexBy('id')->active()->all();

        /** @var UserSubscriptionSender[] $userSubscriptionKeys Ключи */
        $userSubscriptionKeys = UserSubscriptionSender::find()->categoryId($getPlatform)->allChildren($getKeyAlias)->indexBy('id')->active()->all();

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

        /** @var UserSubscriptionSenderCategoryAction[] $userSubscriptionActions Действия */
        $userSubscriptionActions = UserSubscriptionSenderCategoryAction::find()->platformId($getPlatform)->active()->indexBy('id')->all();
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
                ->orderBy('sender_id')
                ->all();
        }

        $result = [];
        // Перебираем подписки
        foreach ($userSubscriptions as $userSubscription) {
            // Подписка
            $result[$userSubscription->id] = [
                'id' => $userSubscription->id,
                'key_id' => $userSubscription->sender_id,
                'platform_id' => $userSubscriptionKeys[$userSubscription->sender_id]->platform_id,
                'alias' => $userSubscriptionKeys[$userSubscription->sender_id]->alias,
                'name' => $userSubscriptionKeys[$userSubscription->sender_id]->name,
                'actions' => $actionsByKeyId[$userSubscription->sender_id],
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
     * Подписки на рассылки
     *
     * @param int $userId
     * @param string $hash
     * @return string
     */
    public function actionIndex($userId, $hash)
    {
        // Get Параметры
        $get = Yii::$app->request->get();
        // Post параметры
        $post = Yii::$app->request->post();
        $getParam = function ($param) use($get, $post) {
            return
                // Если существует GET параметр
                ((isset($get[$param])) ?
                    $get[$param]
                    // Если существует Post параметр
                    : ((isset($post[$param])) ? $post[$param] : false));
        };

        // Обработка параметров
        $params = ['platforms' => null, 'category' => null, 'senders' => null, 'channels' => null, 'actions' => null];
        foreach ($params as $key => $param) { $params[$key] = $getParam($key); }

        // Проверка hash`a
        if ($hash != UserSubscriptionHelper::hash($userId, $params)) {
            return AppHelper::redirectWithFlash('/', 'danger', 'Нарушена целосность запроса.');
        }

        // Параметры, которые необходимо преобразовать
        $arrayKeys = ['platforms', 'senders', 'channels', 'actions'];
        foreach ($arrayKeys as $key) { $params[$key] = explode(',', $params[$key]); }

        /** @var UserSubscriptionSenderCategory[] $senderCategories Категории отправителей и их действия */
        $senderCategoriesQuery = UserSubscriptionSenderCategory::find()->indexBy('id')->platformAlias($params['platforms']);
        if ($params['category']) { $senderCategoriesQuery->where(['alias' => $params['category']]); }
        $senderCategories = $senderCategoriesQuery->with('actions')->all();

        // todo Закончил здесь!!
        /** @var UserSubscriptionSenderCategoryAction[] $senderCategoriesActions Категории отправителей и их действия */
        $senderCategoriesActionsQuery = UserSubscriptionSenderCategoryAction::find()->indexBy('id')->where([$params['platforms']]);
        if ($params['category']) { $senderCategoriesActionsQuery->where(['alias' => $params['category']]); }
        $senderCategoriesActions = $senderCategoriesActionsQuery->with('actions')->all();

        /** @var UserSubscriptionSender[] $senders Отправители */
        $sendersQuery = UserSubscriptionSender::find()->where(['category_id' => array_keys($senderCategories)])->indexBy('id')->active();
        if ($params['keys']) { $sendersQuery->where(['key' => $params['keys']]); }
        $senders = $senders->all();

        // Получаем подписки...
        $userSubscriptions = [];
        if (count($senders)) {
            $userSubscriptions = UserSubscription::find()
                ->userId($userId)
                ->where(['sender_id' => array_keys($senders)])
                ->with(['exemptions' => function ($query) {
                    $query->andWhere(['sender_category_action_id' => array_keys($senderCategoriesActions), 'channel_id' => array_keys($userSubscriptionChannels)]);
                }])
                ->orderBy('key_id')
                ->all();
        }

        // Получения подписок по параметрам
        /** @var UserSubscription[] $userSubscriptions Подписки */
        $userSubscriptions = UserSubscription::getAllByParams($params);

        /** @var UserSubscriptionSender[] $userSubscriptionKeys Ключи */
        $userSubscriptionKeys = UserSubscriptionSender::find()->categoryId($getPlatform)->allChildren($getKeyAlias)->indexBy('id')->active()->all();

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

        /** @var UserSubscriptionSenderCategoryAction[] $userSubscriptionActions Действия */
        $userSubscriptionActions = UserSubscriptionSenderCategoryAction::find()->platformId($getPlatform)->active()->indexBy('id')->all();
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

        $result = [];
        // Перебираем подписки
        foreach ($userSubscriptions as $userSubscription) {
            // Подписка
            $result[$userSubscription->id] = [
                'id' => $userSubscription->id,
                'key_id' => $userSubscription->sender_id,
                'platform_id' => $userSubscriptionKeys[$userSubscription->sender_id]->platform_id,
                'alias' => $userSubscriptionKeys[$userSubscription->sender_id]->alias,
                'name' => $userSubscriptionKeys[$userSubscription->sender_id]->name,
                'actions' => $actionsByKeyId[$userSubscription->sender_id],
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
            || !isset($post['platformId'])
            || !isset($post['keyAlias'])
            || !isset($post['channelAlias'])
            || !isset($post['hash'])
            || !isset($post['active'])
            || !isset($post['redirectUrl'])
        ) { return AppHelper::redirectWithFlash('/', 'danger', 'Не указаны некоторые обязательные post параметры.'); }

        // Проверяем хэш
        if ($post['hash'] != UserSubscriptionHelper::hash($post['userId'], $post['platformId'], $post['keyAlias'], $post['channelAlias'])) { return AppHelper::redirectWithFlash('/', 'danger', 'Нарушена целосность запроса.'); }

        // Пользователь
        $user = User::find($post['userId'])->one();
        if (!$user) { return AppHelper::redirectWithFlash('/', 'danger', 'Пользователь (#' . $post['userId'] . ') не найден.'); }

        // Ключ
        $userSubscriptionKey = UserSubscriptionSender::find()->alias($post['keyAlias'])->one();
        if (!$userSubscriptionKey) { return AppHelper::redirectWithFlash('/', 'danger', 'Ключ подписки (' . $post['keyAlias'] . ') не найден.'); }

        // Канал
        $userSubscriptionChannel = UserSubscriptionChannel::find()->alias($post['channelAlias'])->one();
        if (!$userSubscriptionChannel) { return AppHelper::redirectWithFlash('/', 'danger', 'Канал подписки (#' . $post['channelAlias'] . ') не найден.'); }

        // Подписка на рассылки
        $userSubscription = UserSubscription::find()->userId($post['userId'])->keyId($userSubscriptionKey->id)->channelId($userSubscriptionChannel->id)->one();
        // Если подписка на рассылки существует
        if ($userSubscription) {
            if ($post['active']) {
//                $userSubscriptionExemption = UserSubscriptionExemption::find()->addCondition()
            } else {
                // Добавляем активную или не активную подписку на рассылки
                $userSubscription = new UserSubscriptionExemption();
                $userSubscription->subscription_id = $userSubscription->id;
                $userSubscription->channel_id = $userSubscriptionChannel->id;
                $userSubscription->action_id = $userSubscriptionKey->id;
                $userSubscription->active = $post['active'];
                $userSubscription->save();
            }

            // Изменяем (активируем или деактивируем) подписку на рассылки
            $userSubscription->active = $post['active'];
            $userSubscription->update();
        } else {

        }

        // Возвращаемся по переданному адресу
        AppHelper::redirectWithFlash($post['redirectUrl'], 'success', 'Вы ' . (($post['active']) ? 'подписались на' : 'отписались от') . ' "' . $userSubscriptionKey->name . '" (' . $userSubscriptionChannel->name . ').');
    }
}