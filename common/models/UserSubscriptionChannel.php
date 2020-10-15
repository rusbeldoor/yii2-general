<?php

namespace rusbeldoor\yii2General\common\models;

use yii;

/**
 * User_subscription_channel (ActiveRecord)
 *
 * @property $id int
 * @property $channel string
 * @property $name string
 */
class UserSubscriptionChannel extends \rusbeldoor\yii2General\models\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    { return 'user_subscription_channel'; }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['channel', 'name'], 'required'],
            [['channel', 'name'], 'string', 'max' => 32],
            [['channel'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Ид',
            'channel' => 'Канал',
            'name' => 'Название',
        ];
    }

    /**
     * {@inheritdoc}
     *
     * @return UserSubscriptionChannelQuery the active query used by this AR class.
     */
    public static function find()
    { return new UserSubscriptionChannelQuery(get_called_class()); }

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
