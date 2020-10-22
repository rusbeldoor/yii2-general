<?php

namespace rusbeldoor\yii2General\models;

/**
 * Auth_assignment (ActiveRecord)
 *
 * @property $id int
 * @property $item_name string
 * @property $user_id int
 */
class AuthAssignment extends \rusbeldoor\yii2General\models\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    { return 'auth_assignment'; }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_name', 'user_id'], 'required'],
            self::getRuleString(['item_name'], ['max' => 96]),
            self::getRuleMatchAlias(['item_name']),
            [['item_name', 'user_id'], 'unique', 'targetAttribute' => ['item_name', 'user_id']],
            [['item_name'], 'exist', 'skipOnError' => true, 'targetClass' => AuthItem::className(), 'targetAttribute' => ['item_name' => 'name']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Ид',
            'item_name' => 'Операция/роль',
            'user_id' => 'Пользователь',
        ];
    }

    /**
     * {@inheritdoc}
     *
     * @return AuthAssignmentQuery the active query used by this AR class.
     */
    public static function find()
    { return new AuthAssignmentQuery(get_called_class()); }

    /**
     * Перед удалением
     *
     * @return bool
     */
    public function beforeDelete()
    {
        // if (true) { $this->addError('id', 'Неовзможно удалить #' . $this->id . '.'); }

        return !$this->hasErrors() && parent::beforeDelete();
    }
}
