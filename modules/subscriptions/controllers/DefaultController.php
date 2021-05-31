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
        $params = ['platforms' => null, 'category' => null, 'senders' => null, 'channels' => null, 'actions' => null];
        foreach ($params as $key => $param) { $params[$key] = $getParam($key); }

        // Проверка hash`a
//        if ($hash != UserSubscriptionHelper::hash($userId, $params)) {
//            return AppHelper::redirectWithFlash('/', 'danger', 'Нарушена целостность запроса.');
//        }

        // Параметры, которые необходимо преобразовать
//        $arrayKeys = ['platforms', 'senders', 'channels', 'actions'];
//        foreach ($arrayKeys as $key) {
//            if ($params[$key]) { $params[$key] = explode(',', $params[$key]); }
//        }

        /** @var UserSubscriptionSenderCategory[] $senderCategories Категории отправителей и их действия */
        $senderCategoriesQuery = UserSubscriptionSenderCategory::find()->indexBy('id');
        if ($params['platforms']) {
            $senderCategoriesQuery->joinWith('platform')->andWhere(['platform.alias' => $params['platforms']]);
            if ($params['category']) { $senderCategoriesQuery->alias($params['category']); }
        }
        $senderCategories = $senderCategoriesQuery->all();

        /** @var UserSubscriptionSender[] $senders Отправители */
        $sendersQuery = UserSubscriptionSender::find()->andWhere(['category_id' => array_keys($senderCategories)])->indexBy('id')->active();
        if ($params['senders']) { $sendersQuery->andWhere(['sender_id' => $params['senders']]); }
        $senders = $sendersQuery->all();

        /** @var UserSubscriptionChannel[] $channels Способы доставки уведомлений */
        $channelsQuery = UserSubscriptionChannel::find()->indexBy('id')->active();
        if ($params['channels']) { $channelsQuery->andWhere(['alias' => $params['channels']]); }
        $channels = $channelsQuery->all();

        $senderCategoriesActions = [];
        if (count($senders)) {
            /** @var UserSubscriptionSenderCategoryAction[] $senderCategoriesActions Категории отправителей и их действия */
            $senderCategoriesActionsQuery = UserSubscriptionSenderCategoryAction::find()->indexBy('id')->andWhere(['category_id' => array_keys($senderCategories)]);
            if ($params['actions']) { $senderCategoriesActionsQuery->andWhere(['alias' => $params['actions']]); }
            $senderCategoriesActions = $senderCategoriesActionsQuery->all();
        }

        /** @var UserSubscription[] $userSubscriptions Подписки */
        $userSubscriptions = [];
        $result = [];
        if (count($senderCategoriesActions) && count($channels)) {
            $userSubscriptions = UserSubscription::find()
                ->userId($userId)
                ->andWhere(['sender_id' => array_keys($senders)])
                ->with(['exemptions' => function ($query) use($senderCategoriesActions, $channels) {
                    $query->andWhere(['sender_category_action_id' => array_keys($senderCategoriesActions), 'channel_id' => array_keys($channels)]);
                }])
//                ->orderBy('key')
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
                        'send' => $category->platform_id,
                        'key' => $userSubscription->sender_id,
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