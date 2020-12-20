<?php

namespace rusbeldoor\yii2General\console\controllers;

use rusbeldoor\yii2General\models\YandexDirectAccount;
use rusbeldoor\yii2General\models\YandexDirectAd;
use rusbeldoor\yii2General\models\YandexDirectAdgroup;
use rusbeldoor\yii2General\models\YandexDirectAPI;
use rusbeldoor\yii2General\models\YandexDirectCampaign;
use rusbeldoor\yii2General\helpers\YandexDirectAPIHelper;

/**
 * Крон Яндекс.Директ
 */
class YandexDirectController extends \rusbeldoor\yii2General\components\CronController
{
    /**
     * ...
     */
    public function actionIndex()
    {
        // Акканты Яндекс.Директ
        $yandexDirectAccounts = YandexDirectAccount::find()->all();

        // Перебираем акканты Яндекс.Диреет
        foreach ($yandexDirectAccounts as $yandexDirectAccount) {
            $yandexDirectAPI = new YandexDirectAPI($yandexDirectAccount->url, $yandexDirectAccount->login, $yandexDirectAccount->token);

            // Компании Яндекс.Директ аккаунта
            $apiCampaingsIds = [];
            $apiCampaings = $yandexDirectAPI->getCampaigns();
            for ($i = 0; $i < count($apiCampaings); $i++) {
                $apiCampaing = $apiCampaings[$i];
                $apiCampaing->Id = (string)$apiCampaing->Id;

                $apiCampaingsIds[] = $apiCampaing->Id;

                $campaing = YandexDirectCampaign::findOne($apiCampaing->Id);
                if (!$campaing) {
                    $campaing = new YandexDirectCampaign();
                    $campaing->id = $apiCampaing->Id;
                    $campaing->account_id = $yandexDirectAccount->id;
                }

                $campaing->name = $apiCampaing->Name;
                $campaing->status = $apiCampaing->Status;
                $campaing->state = $apiCampaing->State;
                $campaing->save();
            }
            if (count($apiCampaingsIds)) { YandexDirectCampaign::deleteAll('id NOT IN (' . implode(',', $apiCampaingsIds) . ')'); }

            // Группы объявлений Яндекс.Директ аккаунта
            $apiAdgroupsIds = [];
            $apiAdgroups = $yandexDirectAPI->getAdgroups(['CampaignIds' => $apiCampaingsIds]);
            for ($i = 0; $i < count($apiAdgroups); $i++) {
                $apiAdgroup = $apiAdgroups[$i];
                $apiAdgroup->Id = (string)$apiAdgroup->Id;
                $apiAdgroup->CampaignId = (string)$apiAdgroup->CampaignId;

                $apiAdgroupsIds[] = $apiAdgroup->Id;

                $adgroup = YandexDirectAdgroup::findOne($apiAdgroup->Id);
                if (!$adgroup) {
                    $adgroup = new YandexDirectAdgroup();
                    $adgroup->id = $apiAdgroup->Id;
                    $adgroup->account_id = $yandexDirectAccount->id;
                    $adgroup->campaign_id = $apiAdgroup->CampaignId;
                }

                $adgroup->name = $apiAdgroup->Name;
                $adgroup->status = $apiAdgroup->Status;
                $adgroup->save();
            }
            if (count($apiAdgroupsIds)) { YandexDirectAdgroup::deleteAll('id NOT IN (' . implode(',', $apiAdgroupsIds) . ')'); }

            // Объявления Яндекс.Директ аккаунта
            $apiAdsIds = [];
            $apiAds = $yandexDirectAPI->getAds(['AdGroupIds' => $apiAdgroupsIds]);
            for ($i = 0; $i < count($apiAds); $i++) {
                $apiAd = $apiAds[$i];
                $apiAd->Id = (string)$apiAd->Id;
                $apiAd->CampaignId = (string)$apiAd->CampaignId;
                $apiAd->AdGroupId = (string)$apiAd->AdGroupId;

                $apiAdsIds[] = $apiAd->Id;

                $ad = YandexDirectAd::findOne($apiAd->Id);
                if (!$ad) {
                    $ad = new YandexDirectAd();
                    $ad->id = $apiAd->Id;
                    $ad->account_id = $yandexDirectAccount->id;
                    $ad->campaign_id = $apiAd->CampaignId;
                    $ad->adgroup_id = $apiAd->AdGroupId;
                }

                $ad->title = ((isset($apiAd->TextAd)) ? $apiAd->TextAd->Title : '');
                $ad->status = $apiAd->Status;
                $ad->state = $apiAd->State;
                $ad->save();
            }
            if (count($apiAdsIds)) { YandexDirectAd::deleteAll('id NOT IN (' . implode(',', $apiAdsIds) . ')'); }
        }
    }
}
