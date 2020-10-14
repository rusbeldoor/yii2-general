<?php

namespace rusbeldoor\yii2General\backend\modules\rbac\models;

/**
 * Auth_item_child (ActiveQuery)
 *
 * @see AuthItemChild
 */
class AuthItemChildQuery extends \rusbeldoor\yii2General\models\ActiveQuery
{
    /**
     * Родительский элемент
     *
     * return AuthItemChildQuery     */
    public function parent($name)
    { return $this->andWhere("parent=:parent", [':parent' => $name]); }
}
