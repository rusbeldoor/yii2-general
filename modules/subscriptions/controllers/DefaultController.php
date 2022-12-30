<?php

namespace rusbeldoor\yii2General\modules\subscriptions\controllers;

use rusbeldoor\yii2General\models\UserSubscriptionSenderCategory;
use Yii;
use common\models\User;
use rusbeldoor\yii2General\models\UserSubscription;
use rusbeldoor\yii2General\models\UserSubscriptionLog;
use rusbeldoor\yii2General\models\UserSubscriptionSender;
use rusbeldoor\yii2General\models\UserSubscriptionSenderCategoryAction;
use rusbeldoor\yii2General\models\UserSubscriptionChannel;
use rusbeldoor\yii2General\models\UserSubscriptionException;
use rusbeldoor\yii2General\models\UserSubscriptionExceptionLog;
use rusbeldoor\yii2General\helpers\AppHelper;
use rusbeldoor\yii2General\helpers\UserSubscriptionHelper;
use yii\base\BaseObject;

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
                ->with(['exceptions' => function ($query) use($senderCategoriesActions, $channels) {
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
                        'name' => $senders[$userSubscription->sender_id]->name,
                        'actions' => [],
                        'active' => $userSubscription->active,
                    ];

                    // Перебираем действия
                    foreach ($senderCategoriesActions as $senderCategoriesAction) {
                        // Если начало строки соответствует
                        if ($category->id === $senderCategoriesAction->category_id) {
                            $result[$userSubscription->id]['actions'][$senderCategoriesAction->id] = [
                                'id' => $senderCategoriesAction->id,
                                'alias' => $senderCategoriesAction->alias,
                                'name' => $senderCategoriesAction->name,
                                'channels' => $channelsArray,
                                'active' => false,
                            ];
                        }
                    }

                    // Обрабатываем исключения
                    foreach ($userSubscription->exceptions as $exception) {
                        if ($exception->active) {
                            $result[$userSubscription->id]['actions'][$exception->sender_category_action_id]['channels'][$exception->channel_id]['active'] = false;
                        }
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
    public function actionChangeAll()
    {
        AppHelper::exitIfNotPostRequest();

        // post данные
        $post = Yii::$app->request->post();
        if (
            !isset($post['userId'])
            || !isset($post['subscriptionId'])
            || !isset($post['hash'])
            || !isset($post['action'])
            || !isset($post['redirectUrl'])
        ) { AppHelper::redirectWithFlash('/', 'danger', 'Не указаны некоторые обязательные post параметры.'); }

        // Проверяем хэш
        if ($post['hash'] != UserSubscriptionHelper::hash($post['userId'], '', '', $post['subscriptionId'])) {
            AppHelper::redirectWithFlash('/', 'danger', 'Нарушена целостность запроса.');
        }

        // Пользователь
        $user = User::find()->id($post['userId'])->limit(1)->one();
        if (!$user) { AppHelper::redirectWithFlash('/', 'danger', 'Пользователь (#' . $post['userId'] . ') не найден.'); }

        /** @var UserSubscription $userSubscription Подписка на рассылки */
        $userSubscription = UserSubscription::find()
            ->userId($post['userId'])
            ->id($post['subscriptionId'])
            ->joinWith('sender')
            ->limit(1)
            ->one();
        if (!$userSubscription) { AppHelper::redirectWithFlash('/', 'danger', 'Подписка (#' . $post['subscriptionId'] . ') не найден.'); }


        // Если требуется активация
        if ($post['action'] == 'activate') {
            // Активируем подписку
            $userSubscription->active = 1;
            $userSubscription->save();

            // Записываем лог активации подписки
            $userSubscriptionLog = new UserSubscriptionLog();
            $userSubscriptionLog->subscription_id = $userSubscription->id;
            $userSubscriptionLog->time = time();
            $userSubscriptionLog->user_id = null;
            $userSubscriptionLog->action = 'activate';
            $userSubscriptionLog->data = null;
            $userSubscriptionLog->save();

            // Получаем исключения по подписке
            $userSubscriptionExceptions = UserSubscriptionException::find()->where(['subscription_id' => $userSubscription->id])->all();
            // Перебираем исключения по подписке
            foreach ($userSubscriptionExceptions as $userSubscriptionException) {
                // Если исключение из подписки уже не активно, пропускаем
                if ($userSubscriptionException->active == 0) { continue; }

                // Деактивируем исключение из подписки
                $userSubscriptionException->active = 0;
                $userSubscriptionException->save();

                // Записываем лог деактивации исключений по подписке
                $userSubscriptionExceptionLog = new UserSubscriptionExceptionLog();
                $userSubscriptionExceptionLog->exception_id = $userSubscriptionException->id;
                $userSubscriptionExceptionLog->time = time();
                $userSubscriptionExceptionLog->user_id = null;
                $userSubscriptionExceptionLog->action = 'deactivate';
                $userSubscriptionExceptionLog->data = null;
                $userSubscriptionExceptionLog->save();
            }
        } else {
            // Деактивируем подписку
            $userSubscription->active = 0;
            $userSubscription->save();

            // Записываем лог деактивации подписки
            $userSubscriptionLog = new UserSubscriptionLog();
            $userSubscriptionLog->subscription_id = $userSubscription->id;
            $userSubscriptionLog->time = time();
            $userSubscriptionLog->user_id = null;
            $userSubscriptionLog->action = 'deactivate';
            $userSubscriptionLog->data = null;
            $userSubscriptionLog->save();
        }

        // Возвращаемся по переданному адресу
        AppHelper::redirectWithFlash($post['redirectUrl'], 'success', 'Вы ' . (($post['action'] == 'activate') ? 'добавили' : 'убрали') . ' рассылку от "' . $userSubscription->sender->name . '".');
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
            || !isset($post['subscriptionId'])
            || !isset($post['actionId'])
            || !isset($post['channelId'])
            || !isset($post['hash'])
            || !isset($post['action'])
            || !isset($post['redirectUrl'])
        ) { AppHelper::redirectWithFlash('/', 'danger', 'Не указаны некоторые обязательные post параметры.'); }

        // Проверяем хэш
        if ($post['hash'] != UserSubscriptionHelper::hash($post['userId'], '', '', $post['subscriptionId'], $post['actionId'], $post['channelId'])) {
            AppHelper::redirectWithFlash('/', 'danger', 'Нарушена целостность запроса.');
        }

        // Пользователь
        $user = User::find()->id($post['userId'])->limit(1)->one();
        if (!$user) { AppHelper::redirectWithFlash('/', 'danger', 'Пользователь (#' . $post['userId'] . ') не найден.'); }

        /** @var UserSubscription $userSubscription Подписка на рассылки */
        $userSubscription = UserSubscription::find()
            ->userId($post['userId'])
            ->id($post['subscriptionId'])
            ->joinWith('sender')
            ->limit(1)
            ->one();
        if (!$userSubscription) { AppHelper::redirectWithFlash('/', 'danger', 'Подписка (#' . $post['subscriptionId'] . ') не найден.'); }

        $senderCategoryAction = UserSubscriptionSenderCategoryAction::find()
            ->id($post['actionId'])
            ->limit(1)
            ->one();
        if (!$senderCategoryAction) { AppHelper::redirectWithFlash('/', 'danger', 'Действие (#' .  $post['channelId'] . ') не найдено.'); }

        $channel = UserSubscriptionChannel::find()
            ->id($post['channelId'])
            ->limit(1)
            ->one();
        if (!$senderCategoryAction) { AppHelper::redirectWithFlash('/', 'danger', 'Способ доставки сообщений (#' .  $post['channelId'] . ') не найден.'); }

        $exemption = UserSubscriptionException::find()
            ->where(['subscription_id' => $userSubscription->id, 'sender_category_action_id' => $post['actionId'], 'channel_id' => $post['channelId']])
            ->limit(1)
            ->one();

        if ($exemption) {
            if ($post['action'] == 'activate') {
                $exemption->active = 1;
                $exemption->save();

                $userSubscriptionExceptionLog = new UserSubscriptionExceptionLog();
                $userSubscriptionExceptionLog->exception_id = $exemption->id;
                $userSubscriptionExceptionLog->time = time();
                $userSubscriptionExceptionLog->user_id = null;
                $userSubscriptionExceptionLog->action = 'activate';
                $userSubscriptionExceptionLog->data = null;
                $userSubscriptionExceptionLog->save();
            } else {
                $exemption->active = 0;
                $exemption->save();

                $userSubscriptionExceptionLog = new UserSubscriptionExceptionLog();
                $userSubscriptionExceptionLog->exception_id = $exemption->id;
                $userSubscriptionExceptionLog->time = time();
                $userSubscriptionExceptionLog->user_id = null;
                $userSubscriptionExceptionLog->action = 'deactivate';
                $userSubscriptionExceptionLog->data = null;
                $userSubscriptionExceptionLog->save();
            }
        } else {
            $exemption = new UserSubscriptionException();
            $exemption->subscription_id = $userSubscription->id;
            $exemption->sender_category_action_id = $senderCategoryAction->id;
            $exemption->channel_id = $channel->id;
            $exemption->active = 1;
            $exemption->save();

            $userSubscriptionExceptionLog = new UserSubscriptionExceptionLog();
            $userSubscriptionExceptionLog->exception_id = $exemption->id;
            $userSubscriptionExceptionLog->time = time();
            $userSubscriptionExceptionLog->user_id = null;
            $userSubscriptionExceptionLog->action = 'add';
            $userSubscriptionExceptionLog->data = null;
            $userSubscriptionExceptionLog->save();
        }

        // Возвращаемся по переданному адресу
        AppHelper::redirectWithFlash($post['redirectUrl'], 'success', 'Вы ' . (($post['action'] == 'activate') ? 'добавили' : 'убрали') . ' рассылку от "' . $userSubscription->sender->name . '" на "' . $senderCategoryAction->name . '" (' . $channel->name . ').');
    }
}