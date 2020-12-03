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
 * @property $active int
 */
class UserSubscription extends ActiveRecord
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
            [['user_id', 'key_id', 'channel_id', 'active'], 'integer'],
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
            'active' => 'Активный',
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
        // if (true) { $this->addError('id', 'Элемент #' . $this->id . ' не может быть удалён.'); }

        return !$this->hasErrors() && parent::beforeDelete();
    }
}
