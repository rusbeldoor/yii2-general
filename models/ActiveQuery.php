<?php

namespace rusbeldoor\yii2General\models;

/**
 * Common ActiveQuery
 */
class ActiveQuery extends \yii\db\ActiveQuery
{
    /**
     * Тип
     *
     * @param $type mixed
     * @return AuthItemQuery
     */
    public function type($type)
    { return $this->andWhere("type=:type", [':type' => $type]); }

    /**
     * Статус
     *
     * @param $status mixed
     * @return CronQuery
     */
    public function status($status)
    { return $this->andWhere("active=:status", [':status' => $status]); }

    /**
     * Архивный
     *
     * return ActiveQuery
     */
    public function archive()
    { return $this->andWhere("archive=1"); }

    /**
     * Не архивный
     *
     * return ActiveQuery
     */
    public function notArchive()
    { return $this->andWhere("archive=0"); }

    /**
     * Активный
     *
     * return ActiveQuery
     */
    public function active()
    { return $this->andWhere("active=1"); }

    /**
     * Не активный
     *
     * return ActiveQuery
     */
    public function notActive()
    { return $this->andWhere("active=0"); }
}
