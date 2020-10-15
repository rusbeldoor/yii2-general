<?php

namespace rusbeldoor\yii2General\common\models;

use yii;

/**
 * User_subscription_key (ActiveRecord)
 *
 * @property $id int
 * @property $key string
 * @property $name string
 */
class UserSubscriptionKey extends \rusbeldoor\yii2General\models\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    { return 'user_subscription_key'; }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['key', 'name'], 'required'],
            [['key', 'name'], 'string', 'max' => 128],
            [['key'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Ид',
            'key' => 'Ключ',
            'name' => 'Название',
        ];
    }

    /**
     * {@inheritdoc}
     *
     * @return UserSubscriptionKeyQuery the active query used by this AR class.
     */
    public static function find()
    { return new UserSubscriptionKeyQuery(get_called_class()); }

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
