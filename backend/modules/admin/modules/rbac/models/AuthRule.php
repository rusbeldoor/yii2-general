<?php

namespace rusbeldoor\yii2General\backend\modules\admin\modules\rbac\models;

use yii;

/**
 * Auth_rule (ActiveRecord)
 *
 * @property $name string
 * @property $data resource|null
 * @property $datetime_create string
 * @property $datetime_update string
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
            [['name', 'datetime_create', 'datetime_update'], 'required'],
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
            'name' => 'Название',
            'data' => 'Data',
            'datetime_create' => 'Дата и время создания',
            'datetime_update' => 'Дата и время обновления',
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
