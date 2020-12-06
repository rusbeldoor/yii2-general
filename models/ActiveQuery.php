<?php

namespace rusbeldoor\yii2General\models;

/**
 * Common ActiveQuery
 */
class ActiveQuery extends \yii\db\ActiveQuery
{
    /**
     * Алиас
     *
     * @param $alias string
     * @return AuthItemQuery
     */
    public function alias($alias)
    { return $this->andWhere("alias=:alias", [':alias' => $alias]); }

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
     * @return ActiveQuery
     */
    public function archive()
    { return $this->andWhere("archive=1"); }

    /**
     * Не архивный
     *
     * @param $fieldValue int|null
     * @param $fieldName string
     * @return ActiveQuery
     */
    public function notArchive($fieldValue = null, $fieldName = 'id')
    { return $this->andWhere("archive=0" . (($fieldValue !== null) ? " OR " . $fieldName . "=" . ((is_string($fieldValue)) ? "\"" . $fieldValue . "\"" : $fieldValue) : "")); }

    /**
     * Активный
     *
     * @return ActiveQuery
     */
    public function active()
    { return $this->andWhere("active=1"); }

    /**
     * Не активный
     *
     * @return ActiveQuery
     */
    public function notActive()
    { return $this->andWhere("active=0"); }
}
