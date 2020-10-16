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
        $keyAlias = ((isset($get['key'])) ? $get['key'] : null);
        $getChannelsAliases = null;
        $channelsAliases = null;
        if (isset($get['channels'])) {
            $getChannelsAliases = $get['channels'];
            $channelsAliases = explode(',', $getChannelsAliases);
        }

        // Проверяем хэш
        $subscriptionHash =  hash('sha256', $userId . $keyAlias . $getChannelsAliases);
        $subscriptionHash = hash('sha256', $subscriptionHash . $this->module->salt);
        if ($hash != $subscriptionHash) { return AppHelper::redirectWitchFlash('/', 'danger', 'Доступ запрещён.'); }

        $result = [
            'name' => '', // Название
            'childKeysAliases' => [],  // Дочерние ключи
            'channelsAliases' => [], // Каналы
        ];;

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
        $userSubscriptions = UserSubscription::find()->userId($userId)->keysIds($userSubscriptionKeysIds)->channelsIds($userSubscriptionChannelsIds)->all();

        // Перебираем подписки
        foreach ($userSubscriptions as $userSubscription) {
            // Получаем все ключи подписки
            $keysAliases = explode(';', $userSubscriptionKeys[$userSubscription->key_id]->alias);
            // Указатель на массив
            $pointer = &$result;
            // Перебираем ключи подписки
            foreach ($keysAliases as $keyAlias) {
                // Передвигаем указатель
                $pointer = &$pointer['childKeysAliases'];
                // Если такого ключа еще не встречалось
                if (!isset($pointer[$keyAlias])) {
                    // Добавляем ключ
                    $pointer[$keyAlias] = [
                        'name' => '', // Название
                        'childKeysAliases' => [],  // Дочерние ключи
                        'channelsAliases' => [], // Каналы
                    ];
                }
            }
            // Запоминаем имя последнего ключа
            $pointer['name'] = $userSubscriptionKeys[$userSubscription->key_id]->name;
            // Запоминаем каналы их имена
            $pointer['channelsAliases'][$userSubscriptionChannels[$userSubscription->channel_id]->alias] = $userSubscriptionChannels[$userSubscription->channel_id]->name;
        }
        return $this->render('subscriptions', ['result' => $result['childKeysAliases']]);
    }
}
