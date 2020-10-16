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
     * @param $user_id int
     * @param $hash string
     * @return string
     */
    public function actionIndex($user_id, $hash)
    {
        $get = yii::$app->request->get();
        $keyAlias = ((isset($get['key'])) ? $get['key'] : null);
        $getChannelsAliases = null;
        $channelsAliases = null;
        if (isset($get['channels'])) {
            $getChannelsAliases = $get['channels'];
            $channelsAliases = explode(',', $getChannelsAliases);
        }

        // Проверяем хэш
        $subscriptionHash =  hash('sha256', $user_id . $keyAlias . $getChannelsAliases);
        $subscriptionHash = hash('sha256', $subscriptionHash . $this->module->salt);
        if ($hash != $subscriptionHash) { return AppHelper::redirectWitchFlash('/', 'danger', 'Доступ запрещён.'); }

        // Ключи
        $userSubscriptionKeys = [];
        if ($keyAlias) { UserSubscriptionKey::find()->allChilds($keyAlias)->all(); }
        $userSubscriptionKeys = ArrayHelper::arrayByField($userSubscriptionKeys, 'id');
        $userSubscriptionKeysIds = array_keys($userSubscriptionKeys);

        // Каналы
        $userSubscriptionChannels = [];
        if ($channelsAliases) { $userSubscriptionChannels = UserSubscriptionChannel::find()->aliases($channelsAliases)->all(); }
        $userSubscriptionChannels = ArrayHelper::arrayByField($userSubscriptionChannels, 'id');
        $userSubscriptionChannelsIds = array_keys($userSubscriptionChannels);

        // Подписки
        $userSubscriptions = UserSubscription::find()->keysIds($userSubscriptionKeysIds)->channelsIds($userSubscriptionChannelsIds)->all();
        $userSubscriptionsFormatted = [];

        // Перебираем подписки
        foreach ($userSubscriptions as $userMailing) {
            if (!isset($userSubscriptionsFormatted[$userMailing->platform_id])) { $userSubscriptionsFormatted[$userMailing->platform_id] = []; }
            switch ($userMailing->elem_type) {
                case 'organisation': $name = 'Рассылка от организаций'; break;
                case 'city': $name = 'Рассылка по городам'; break;
                default: $name = 'Основное';
            }
            if (!isset($userSubscriptionsFormatted[$userMailing->platform_id][$userMailing->elem_type])) { $userSubscriptionsFormatted[$userMailing->platform_id][$userMailing->elem_type] = ['name' => $name, 'elemIds' => []]; }
            if (!isset($userSubscriptionsFormatted[$userMailing->platform_id][$userMailing->elem_type]['elemIds'][$userMailing->elem_id])) { $userSubscriptionsFormatted[$userMailing->platform_id][$userMailing->elem_type]['elemIds'][$userMailing->elem_id] = ['name' => '', 'ways' => []]; }
            // Заполнить name для каждого элемента switch внутри по case запросы по бд, либо не запросы
            if (!in_array($userMailing->way, $userSubscriptionsFormatted[$userMailing->platform_id][$userMailing->elem_type]['elemIds'][$userMailing->elem_id]['ways'])) { $userSubscriptionsFormatted[$userMailing->platform_id][$userMailing->elem_type]['elemIds'][$userMailing->elem_id]['ways'][] = $userMailing->way; }
        }
        return $this->render('subscriptions', ['userSubscriptionsFormatted' => $userSubscriptionsFormatted]);
    }
}
