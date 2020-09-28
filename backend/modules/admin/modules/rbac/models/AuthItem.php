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
            [['name', 'type'], 'required'],
            [['type'], 'integer'],
            [['description', 'data'], 'string'],
            self::getRuleString(['name', 'rule_name'], ['max' => 96]),
            self::getRuleMatchAlias('name'),
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

    /**
     * Это операция
     *
     * @return bool
     */
    public function isPermission()
    { return $this->type == 2; }

    /**
     * Это роль
     *
     * @return bool
     */
    public function isRole()
    { return $this->type == 1; }
}
