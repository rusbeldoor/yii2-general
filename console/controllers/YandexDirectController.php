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
        YandexDirectAd::deleteAll();
        YandexDirectAdgroup::deleteAll();
        YandexDirectCampaign::deleteAll();

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

                $campaign = YandexDirectCampaign::findOne($apiCampaing->Id);
                if (!$campaign) {
                    $campaign = new YandexDirectCampaign();
                    $campaign->id = $apiCampaing->Id;
                    $campaign->account_id = $yandexDirectAccount->id;
                }

                $campaign->name = $apiCampaing->Name;
                $campaign->status = $apiCampaing->Status;
                $campaign->state = $apiCampaing->State;
                $campaign->save();
            }

            foreach ($apiCampaingsIds as $apiCampaingsId) {
                // Группы объявлений Яндекс.Директ аккаунта
                $apiAdgroupsIds = [];
                $apiAdgroups = $yandexDirectAPI->getAdgroups(['CampaignIds' => [$apiCampaingsId]]);
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
            }
        }
    }
}
