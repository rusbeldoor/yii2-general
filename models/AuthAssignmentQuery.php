<?php
namespace rusbeldoor\yii2General\models;

/**
 * Auth_assignment (ActiveQuery)
 *
 * @see AuthAssignment
 */
class AuthAssignmentQuery extends ActiveQuery
{
    /**
     * Алиас
     *
     * @return AuthItemQuery
     */
    public function itemName($item_name)
    { return $this->andWhere("item_name=:item_name", [':item_name' => $item_name]); }
}
