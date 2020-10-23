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
     * return AuthItemChildQuery     */
    public function parent($name)
    { return $this->andWhere("parent=:parent", [':parent' => $name]); }
}
