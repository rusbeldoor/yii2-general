<?php

namespace rusbeldoor\yii2General\backend\modules\admin\modules\rbac\models;

use yii;

/**
 * Auth_rule (ActiveRecord)
 *
 * @property $id int
 * @property $name string
 * @property $data resource|null
 */
class AuthRule extends \rusbeldoor\yii2General\models\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    { return 'auth_rule'; }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['data'], 'string'],
            [['name'], 'string', 'max' => 64],
            [['name'], 'unique'],
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
            'data' => 'Data',
        ];
    }

    /**
     * {@inheritdoc}
     *
     * @return AuthRuleQuery the active query used by this AR class.
     */
    public static function find()
    { return new AuthRuleQuery(get_called_class()); }

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
