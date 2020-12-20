<?php

namespace rusbeldoor\yii2General\console\controllers;

use rusbeldoor\yii2General\models\YandexDirectAd;
use rusbeldoor\yii2General\models\YandexDirectAdgroup;
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
        $apiCampaingsIds = [];
        $apiCampaings = YandexDirectAPIHelper::getCampaigns();
        for ($i = 0; $i < count($apiCampaings); $i++) {
            $apiCampaing = $apiCampaings[$i];
            $apiCampaing->Id = (string)$apiCampaing->Id;

            $apiCampaingsIds[] = $apiCampaing->Id;

            $campaing = YandexDirectCampaign::findOne($apiCampaing->Id);
            if (!$campaing) {
                $campaing = new YandexDirectCampaign();
                $campaing->id = $apiCampaing->Id;
            }

            $campaing->name = $apiCampaing->Name;
            $campaing->status = $apiCampaing->Status;
            $campaing->state = $apiCampaing->State;
            $campaing->save();
        }

        $apiAdgroupsIds = [];
        $apiAdgroups = YandexDirectApiHelper::getAdgroups(['CampaignIds' => $apiCampaingsIds]);
        for ($i = 0; $i < count($apiAdgroups); $i++) {
            $apiAdgroup = $apiAdgroups[$i];
            $apiAdgroup->Id = (string)$apiAdgroup->Id;
            $apiAdgroup->CampaignId = (string)$apiAdgroup->CampaignId;

            $apiAdgroupsIds[] = $apiAdgroup->Id;

            $adgroup = YandexDirectAdgroup::findOne($apiAdgroup->Id);
            if (!$adgroup) {
                $adgroup = new YandexDirectAdgroup();
                $adgroup->id = $apiAdgroup->Id;
                $adgroup->campaign_id = $apiAdgroup->CampaignId;
            }

            $adgroup->name = $apiAdgroup->Name;
            $adgroup->status = $apiAdgroup->Status;
            $adgroup->save();
        }

        $apiAdsIds = [];
        $apiAds = YandexDirectApiHelper::getAds(['AdGroupIds' => $apiAdgroupsIds]);
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
                $ad->campaign_id = $apiAd->CampaignId;
                $ad->adgroup_id = $apiAd->AdGroupId;
            }

            if (isset($apiAd->TextAd)) {
                $ad->title = $apiAd->TextAd->Title;
            } else {
                $ad->title = '';
            }
            $ad->status = $apiAd->Status;
            $ad->state = $apiAd->State;
            $ad->save();
        }
    }
}
