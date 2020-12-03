<?php

namespace rusbeldoor\yii2General\console\controllers;

use rusbeldoor\yii2General\helpers\DatetimeHelper;
use rusbeldoor\yii2General\models\CronLog;

/**
 * Контроллер
 */
class RemovingOutdatedDataController extends \rusbeldoor\yii2General\components\CronController
{
    // Время устаревания
    public $obsolescenceTime = [
        'CronLog' => 60 * 60 * 24 * 30 * 12,
    ];

    /**
     * ...
     */
    public function actionIndex()
    {
        // Логи по кронам
        CronLog::deleteAll(
            "datetime_start<:datetime_start",
            [':datetime_start' => DatetimeHelper::formatYearMonthDayHourMinuteSecond(time() - $this->obsolescenceTime['CronLog'])]
        );
    }
}
