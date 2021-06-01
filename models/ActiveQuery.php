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
     * @param string|array $id
     * @return self
     */
    public function id($id)
    { return $this->andWhere([$this->getPrimaryTableName() . '.id' => $id]); }

    /**
     * Алиас
     *
     * @param string|array $alias
     * @return self
     */
    public function alias($alias)
    { return $this->andWhere([$this->getPrimaryTableName() . '.alias' => $alias]); }

    /**
     * Тип
     *
     * @param string|array $type
     * @return self
     */
    public function type($type)
    { return $this->andWhere([$this->getPrimaryTableName() . '.type' => $type]); }

    /**
     * Статус
     *
     * @param string|array $status
     * @return self
     */
    public function status($status)
    { return $this->andWhere([$this->getPrimaryTableName() . '.status' => $status]); }

    /**
     * Архивный
     *
     * @return self
     */
    public function archive()
    { return $this->andWhere([$this->getPrimaryTableName() . '.archive' => 1]); }

    /**
     * Не архивный
     *
     * @param int|null $fieldValue
     * @param string $fieldName
     * @return self
     */
    public function notArchive($fieldValue = null, $fieldName = 'id')
    { return $this->andWhere($this->getPrimaryTableName() . ".archive=0" . (($fieldValue !== null) ? " OR " . $this->getPrimaryTableName() . ".$fieldName=" . ((is_string($fieldValue)) ? "\"$fieldValue\"" : $fieldValue) : "")); }

    /**
     * Активный
     *
     * @return self
     */
    public function active()
    { return $this->andWhere([$this->getPrimaryTableName() . '.active' => 1]); }

    /**
     * Не активный
     *
     * @return self
     */
    public function notActive()
    { return $this->andWhere([$this->getPrimaryTableName() . '.active' => 0]); }
}
