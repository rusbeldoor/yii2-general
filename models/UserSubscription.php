<?php

namespace rusbeldoor\yii2General\models;

use yii;

/**
 * User_subscription (ActiveRecord)
 *
 * @property $id int
 * @property $user_id int
 * @property $key_id int
 * @property $channel_id int
 */
class UserSubscription extends \rusbeldoor\yii2General\models\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    { return 'user_subscription'; }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'key_id', 'channel_id'], 'required'],
            [['user_id', 'key_id', 'channel_id'], 'integer'],
            [['user_id', 'key_id', 'channel_id'], 'unique', 'targetAttribute' => ['user_id', 'key_id', 'channel_id']],
            [['channel_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserSubscriptionChannel::className(), 'targetAttribute' => ['channel_id' => 'id']],
            [['key_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserSubscriptionKey::className(), 'targetAttribute' => ['key_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Ид',
            'user_id' => 'Пользователь',
            'key_id' => 'Ключ',
            'channel_id' => 'Канал',
        ];
    }

    /**
     * {@inheritdoc}
     *
     * @return UserSubscriptionQuery the active query used by this AR class.
     */
    public static function find()
    { return new UserSubscriptionQuery(get_called_class()); }

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
