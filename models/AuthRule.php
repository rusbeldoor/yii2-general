<?php

namespace rusbeldoor\yii2General\models;

/**
 * Auth_rule (ActiveRecord)
 *
 * @property $id int
 * @property $name string
 * @property $data resource|null
 */
class AuthRule extends ActiveRecord
{
    /** {@inheritdoc} */
    public static function tableName()
    { return 'auth_rule'; }

    /** {@inheritdoc} */
    public function rules()
    { return [
        [['name'], 'required'],
        [['data'], 'string'],
        self::getRuleString(['name'], ['max' => 96]),
        self::getRuleMatchAlias(['name']),
        [['name'], 'unique'],
    ]; }

    /** {@inheritdoc} */
    public function attributeLabels()
    {
        return [
            'id' => 'Ид',
            'name' => 'Алиас',
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
        // if (true) { $this->addError('id', 'Элемент #' . $this->id . ' не может быть удалён.'); }

        return !$this->hasErrors() && parent::beforeDelete();
    }
}
