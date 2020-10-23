<?php
namespace rusbeldoor\yii2General\models;

/**
 * Auth_item (ActiveQuery)
 *
 * @see AuthItem
 */
class AuthItemQuery extends ActiveQuery
{
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
     * Есть родители по имени
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
     * Нет родителей по имени
     *
     * @param $name string
     * @return AuthItemQuery
     */
    public function notOfRole($name)
    {
        $this->leftJoin("auth_item_child aic", "aic.parent=:parent AND aic.child=name", [':parent' => $name]);
        $this->andWhere("name!=:name", [':name' => $name]);
        $this->andWhere("aic.id IS NULL");
        return $this;
    }
}
