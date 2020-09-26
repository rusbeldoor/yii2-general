<?php

namespace rusbeldoor\yii2General\backend\modules\admin\modules\rbac\models;

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
     * Есть родитель по имени
     *
     * @param $name string
     * @return AuthItemQuery
     */
    public function haveParentByName($name)
    {
        $this->join('auth_item_child', 'auth_item_child.parent=:parent', [':parent' => $name]);
        $this->addWhere("auth_item_child.id IS NOT NULL");
        return $this;
    }

    /**
     * Нет родителя по имени
     *
     * @param $name string
     * @return AuthItemQuery
     */
    public function notHaveParentByName($name)
    {
        $this->join('auth_item_child', 'auth_item_child.parent=:parent', [':parent' => $name]);
        $this->addWhere("auth_item_child.id IS NULL");
        return $this;
    }
}
