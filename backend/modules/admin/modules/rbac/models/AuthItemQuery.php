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
     * Тип операции
     *
     * @return AuthItemQuery
     */
    public function typePermission()
    { return $this->type(2); }

    /**
     * Тип роли
     *
     * @return AuthItemQuery
     */
    public function typeRole()
    { return $this->type(2); }
}
