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
     * @param string $alias
     * @return AuthItemQuery
     */
    public function alias($alias)
    { return $this->andWhere([$this->getPrimaryTableName() . '.alias' => $alias]); }

    /**
     * Тип
     *
     * @param mixed $type
     * @return AuthItemQuery
     */
    public function type($type)
    { return $this->andWhere([$this->getPrimaryTableName() . '.type' => $type]); }

    /**
     * Статус
     *
     * @param mixed $status
     * @return CronQuery
     */
    public function status($status)
    { return $this->andWhere([$this->getPrimaryTableName() . '.status' => $status]); }

    /**
     * Архивный
     *
     * @return ActiveQuery
     */
    public function archive()
    { return $this->andWhere([$this->getPrimaryTableName() . '.archive' => 1]); }

    /**
     * Не архивный
     *
     * @param int|null $fieldValue
     * @param string $fieldName
     * @return ActiveQuery
     */
    public function notArchive($fieldValue = null, $fieldName = 'id')
    { return $this->andWhere($this->getPrimaryTableName() . ".archive=0" . (($fieldValue !== null) ? " OR " . $this->getPrimaryTableName() . ".$fieldName=" . ((is_string($fieldValue)) ? "\"$fieldValue\"" : $fieldValue) : "")); }

    /**
     * Активный
     *
     * @return ActiveQuery
     */
    public function active()
    { return $this->andWhere([$this->getPrimaryTableName() . '.active' => 1]); }

    /**
     * Не активный
     *
     * @return ActiveQuery
     */
    public function notActive()
    { return $this->andWhere([$this->getPrimaryTableName() . '.active' => 0]); }
}
