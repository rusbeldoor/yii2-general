<?php

namespace rusbeldoor\yii2General\backend\modules\administrator\modules\rbac\models;

/**
 * Auth_item (ActiveQuery)
 *
 * @see AuthItem
 */
class AuthItemQuery extends \rusbeldoor\yii2General\models\ActiveQuery
{
    /**
     * Тип
     *
     * @param $type int
     * @return AuthItemQuery
     */
    public function type($type)
    { return $this->andWhere("type=:type", [':type' => $type]); }

    /**
     * Тип роли
     *
     * @return AuthItemQuery
     */
    public function typeRole()
    { return $this->type(1); }

    /**
     * Тип операции
     *
     * @return AuthItemQuery
     */
    public function typePermission()
    { return $this->type(2); }

    /**
     * Есть родителя по имени
     *
     * @param $name string
     * @return AuthItemQuery
     */
    public function ofRole($name)
    {
        $this->leftJoin('auth_item_child aic', 'aic.child=name');
        $this->andWhere("aic.parent=:parent", [':parent' => $name]);
        $this->andWhere("name!=:name", [':name' => $name]);
        return $this;
    }

    /**
     * Нет родитель по имени
     *
     * @param $name string
     * @return AuthItemQuery
     */
    public function notOfRole($name)
    {
        $this->leftJoin('auth_item_child aic', 'aic.child=name');
        $this->andWhere("aic.parent IS NULL OR aic.parent!=:parent", [':parent' => $name]);
        $this->andWhere("name!=:name", [':name' => $name]);
        return $this;
    }
}
