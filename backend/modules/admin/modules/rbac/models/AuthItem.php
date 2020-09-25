<?php

namespace rusbeldoor\yii2General\backend\modules\admin\modules\rbac\models;

use yii;

/**
 * Auth_item (ActiveRecord)
 *
 * @property $id int
 * @property $name string
 * @property $type int
 * @property $description string|null
 * @property $rule_name string|null
 * @property $data resource|null
 * @property $datetime_create string
 * @property $datetime_update string
 */
class AuthItem extends \rusbeldoor\yii2General\models\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    { return 'auth_item'; }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'type', 'datetime_create', 'datetime_update'], 'required'],
            [['type'], 'integer'],
            [['description', 'data'], 'string'],
            [['name', 'rule_name'], 'string', 'max' => 64],
            [['name'], 'unique'],
            [['rule_name'], 'exist', 'skipOnError' => true, 'targetClass' => AuthRule::className(), 'targetAttribute' => ['rule_name' => 'name']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Ид',
            'name' => 'Название',
            'type' => 'Тип',
            'description' => 'Описание',
            'rule_name' => 'Rule Name',
            'data' => 'Data',
            'datetime_create' => 'Дата и время создания',
            'datetime_update' => 'Дата и время обновления',
        ];
    }

    /**
     * {@inheritdoc}
     *
     * @return AuthItemQuery the active query used by this AR class.
     */
    public static function find()
    { return new AuthItemQuery(get_called_class()); }

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
