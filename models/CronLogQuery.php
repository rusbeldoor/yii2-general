<?php
namespace rusbeldoor\yii2General\models;

/**
 * Cron_log (ActiveQuery)
 *
 * @see CronLog
 */
class CronLogQuery extends ActiveQuery
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
    { return $this->orderBy('datetime_start DESC')->limit(1); }

    /**
     * Не завершённый
     *
     * @return AuthItemQuery
     */
    public function notComplete()
    { return $this->andWhere("datetime_complete IS NULL"); }
}
