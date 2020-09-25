<?php

namespace rusbeldoor\yii2General\backend\modules\admin\modules\rbac\models;

/**
 * Auth_assignment (ActiveRecord)
 *
 * @property $item_name string
 * @property $user_id int
 * @property $datetime_create string
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
            [['item_name', 'user_id', 'datetime_create'], 'required'],
            [['item_name'], 'string', 'max' => 64],
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
            'item_name' => 'Item Name',
            'user_id' => 'Пользователь',
            'datetime_create' => 'Дата и время создания',
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
