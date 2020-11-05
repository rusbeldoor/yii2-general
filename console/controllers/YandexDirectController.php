<?php
namespace rusbeldoor\yii2General\console\controllers;

use rusbeldoor\yii2General\helpers\YandexDirectAPIHelper;

/**
 * Контроллер
 */
class YandexDirectController extends \rusbeldoor\yii2General\components\CronController
{
    /**
     *
     */
    public function actionIndex()
    {
        $campaings = YandexDirectAPIHelper::getCampaigns();
        foreach ($campaings as $campaing) {
            print_r($campaing);
        }
    }
}
