<?php

namespace rusbeldoor\yii2General\models;

/**
 * Cron_log (ActiveQuery)
 *
 * @see CronLog
 */
class CronLogQuery extends \rusbeldoor\yii2General\models\ActiveQuery
{
    /**
     * Крон
     *
     * @param $cron_id int
     * @return AuthItemQuery
     */
    public function cron($cron_id)
    { return $this->andWhere("cron_id=:cron_id", [':cron_id' => $cron_id]); }

    /**
     * Последний запуск
     *
     * @return AuthItemQuery
     */
    public function lastStart()
    { return $this->andWhere("MAX(datetime_start)"); }

    /**
     * Не завершённый
     *
     * @return AuthItemQuery
     */
    public function notComplete()
    { return $this->andWhere("datetime_complete IS NULL"); }
}
