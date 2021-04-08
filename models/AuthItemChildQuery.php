<?php

namespace rusbeldoor\yii2General\models;

/**
 * Auth_item_child (ActiveQuery)
 *
 * @see AuthItemChild
 */
class AuthItemChildQuery extends ActiveQuery
{
    /**
     * Родительский элемент
     *
     * @param string $name
     * @return AuthItemChildQuery
     */
    public function parent($name)
    { return $this->andWhere("parent=:parent", [':parent' => $name]); }

    /**
     * Дочерний элемент
     *
     * @param string $name
     * @return AuthItemChildQuery
     */
    public function child($name)
    { return $this->andWhere("child=:child", [':child' => $name]); }
}
