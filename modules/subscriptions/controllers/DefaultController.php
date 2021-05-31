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
        $params = ['platforms' => null, 'category' => null, 'senderKeys' => null, 'channels' => null, 'actions' => null];
        foreach ($params as $key => $param) { $params[$key] = $getParam($key); }

        // Проверка hash`a
        if ($hash != UserSubscriptionHelper::hash($userId, $params['platforms'], $params['category'], $params['senderKeys'], $params['actions'], $params['channels'])) {
            return AppHelper::redirectWithFlash('/', 'danger', 'Нарушена целостность запроса.');
        }

        // Параметры, которые необходимо преобразовать
        $arrayKeys = ['platforms', 'senderKeys', 'channels', 'actions'];
        foreach ($arrayKeys as $key) {
            if ($params[$key]) { $params[$key] = explode(',', $params[$key]); }
        }

        /** @var UserSubscriptionSenderCategory[] $senderCategories Категории отправителей и их действия */
        $senderCategoriesQuery = UserSubscriptionSenderCategory::find()->indexBy('id');
        if ($params['platforms']) {
            $senderCategoriesQuery->joinWith('platform', false)->andWhere(['platform.alias' => $params['platforms']]);
            if ($params['category']) { $senderCategoriesQuery->alias($params['category']); }
        }
        $senderCategories = $senderCategoriesQuery->all();

        /** @var UserSubscriptionSender[] $senders Отправители */
        $sendersQuery = UserSubscriptionSender::find()->andWhere(['category_id' => array_keys($senderCategories)])->indexBy('id')->active();
        if ($params['senderKeys']) { $sendersQuery->andWhere(['key' => $params['senderKeys']]); }
        $senders = $sendersQuery->all();

        /** @var UserSubscriptionChannel[] $channels Способы доставки уведомлений */
        $channelsQuery = UserSubscriptionChannel::find()->indexBy('id')->active();
        if ($params['channels']) { $channelsQuery->alias($params['channels']); }
        $channels = $channelsQuery->all();

        $senderCategoriesActions = [];
        if (count($senders)) {
            /** @var UserSubscriptionSenderCategoryAction[] $senderCategoriesActions Категории отправителей и их действия */
            $senderCategoriesActionsQuery = UserSubscriptionSenderCategoryAction::find()->indexBy('id')->andWhere(['category_id' => array_keys($senderCategories)]);
            if ($params['actions']) { $senderCategoriesActionsQuery->andWhere(['alias' => $params['actions']]); }
            $senderCategoriesActions = $senderCategoriesActionsQuery->all();
        }

        $result = [];
        if (count($senderCategoriesActions) && count($channels)) {
            /** @var UserSubscription[] $userSubscriptions Подписки */
            $userSubscriptions = UserSubscription::find()
                ->userId($userId)
                ->andWhere(['sender_id' => array_keys($senders)])
                ->joinWith(['sender' => function ($query) { return $query->joinWith('category', false); }], false)
                ->with(['exemptions' => function ($query) use($senderCategoriesActions, $channels) {
                    $query->andWhere(['sender_category_action_id' => array_keys($senderCategoriesActions), 'channel_id' => array_keys($channels)]);
                }])
                ->orderBy('user_subscription_sender_category.platform_id, user_subscription_sender.key')
                ->all();

            if (count($userSubscriptions)) {
                // Обрабатываем каналы
                $channelsArray = [];
                foreach ($channels as $channel) {
                    $channelsArray[$channel->id] = [
                        'id' => $channel->id,
                        'alias' => $channel->alias,
                        'name' => $channel->name,
                        'active' => true,
                    ];
                }

                // Перебираем подписки
                foreach ($userSubscriptions as $userSubscription) {
                    $category = $senderCategories[$senders[$userSubscription->sender_id]->category_id];
                    $result[$userSubscription->id] = [
                        'id' => $userSubscription->id,
                        'platformId' => $category->platform_id,
                        'category' => $category->alias,
                        'senderKey' => $senders[$userSubscription->sender_id]->key,
                        'name' => $senders[$userSubscription->sender_id]->name,
                        'actions' => [],
                        'active' => true,
                    ];

                    // Перебираем действия
                    foreach ($senderCategoriesActions as $senderCategoriesAction) {
                        // Если начало строки соответствует
                        if ($category->id === $senderCategoriesAction->category_id) {
                            $result[$userSubscription->id]['actions'][$senderCategoriesAction->id] = [
                                'id' => $senderCategoriesAction->id,
                                'name' => $senderCategoriesAction->name,
                                'channels' => $channels,
                                'active' => true,
                            ];
                        }
                    }

                    // Обрабатываем исключения
                    foreach ($userSubscription->exemptions as $exemption) {
                        $result[$userSubscription->id]['actions'][$exemption->sender_category_action_id]['channels'][$exemption->channel_id]['active'] = false;
                    }
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
            || !isset($post['category'])
            || !isset($post['senderKey'])
            || !isset($post['actionId'])
            || !isset($post['channelId'])
            || !isset($post['hash'])
            || !isset($post['active'])
            || !isset($post['redirectUrl'])
        ) { AppHelper::redirectWithFlash('/', 'danger', 'Не указаны некоторые обязательные post параметры.'); }

        // Проверяем хэш
        if ($post['hash'] != UserSubscriptionHelper::hash($post['userId'], $post['platformId'], $post['category'], $post['senderKey'], $post['actionId'], $post['channelId'])) {
            AppHelper::redirectWithFlash('/', 'danger', 'Нарушена целосность запроса.');
        }

        // Пользователь
        $user = User::find($post['userId'])->one();
        if (!$user) { AppHelper::redirectWithFlash('/', 'danger', 'Пользователь (#' . $post['userId'] . ') не найден.'); }

        // Ключ
//        $userSubscriptionKey = UserSubscriptionSender::find()->alias($post['keyAlias'])->one();
//        if (!$userSubscriptionKey) { AppHelper::redirectWithFlash('/', 'danger', 'Ключ подписки (' . $post['keyAlias'] . ') не найден.'); }

        // Канал
//        $userSubscriptionChannel = UserSubscriptionChannel::find()->alias($post['channelAlias'])->one();
//        if (!$userSubscriptionChannel) { AppHelper::redirectWithFlash('/', 'danger', 'Канал подписки (#' . $post['channelAlias'] . ') не найден.'); }

        /** @var UserSubscription $userSubscription Подписка на рассылки */
        $userSubscription =
            UserSubscription::find()
                ->userId($post['userId'])
                ->leftWith([
                    'sender' => function ($query) use($post) {
                        $query->leftWith(['category' => function ($query) use($post) {
                            $query->andWhere(['platform_id' => $post['platformId'], 'alias' => $post['category']]);
                        }], false);
                        $query->andWhere(['key' => $post['senderKey']]);
                    },
                ])
                ->with([
                    'exemptions' => function ($query) use($post) {
                        $query->andWhere(['action_id' => $post['actionId'], 'channel_id' => $post['channelId']]);
                    },
                ])
                ->andWhere("category.id IS NOT NULL")
                ->one();

        // Если подписка на рассылки существует
//        if ($userSubscription) {
//            if ($post['active']) {
////                $userSubscriptionExemption = UserSubscriptionExemption::find()->addCondition()
//            } else {
//                // Добавляем активную или не активную подписку на рассылки
//                $userSubscription = new UserSubscriptionExemption();
//                $userSubscription->subscription_id = $userSubscription->id;
//                $userSubscription->channel_id = $userSubscriptionChannel->id;
//                $userSubscription->action_id = $userSubscriptionKey->id;
//                $userSubscription->active = $post['active'];
//                $userSubscription->save();
//            }
//
//            // Изменяем (активируем или деактивируем) подписку на рассылки
//            $userSubscription->active = $post['active'];
//            $userSubscription->update();
//        } else {
//
//        }

        // Возвращаемся по переданному адресу
        AppHelper::redirectWithFlash($post['redirectUrl'], 'success', 'Вы ' . (($post['active']) ? 'подписались на' : 'отписались от') . ' "' . $userSubscription->sender . '" (канал сообщений!!!).');
    }
}