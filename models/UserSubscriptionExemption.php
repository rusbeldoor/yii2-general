<?php

namespace rusbeldoor\yii2General\models;

/**
 * user_subscription_exception (ActiveRecord)
 *
 * @property int $id
 * @property int $subscription_id
 * @property int $channel_id
 * @property int $action_id
 */
class UserSubscriptionExemption extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName() { return 'user_subscription_exception'; }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subscription_id'], 'required'],
            [['subscription_id, channel_id, action_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Ид',
            'subscription_id' => 'Подписка',
            'channel_id' => 'Канал',
            'action_id' => 'Действие',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getSubscription()
    { return $this->hasOne(UserSubscription::class, ['id' => 'subscription_id']); }

    /**
     * {@inheritdoc}
     */
    public function getSubscriptionChannel()
    { return $this->hasOne(UserSubscriptionChannel::class, ['id' => 'channel_id']); }

    /**
     * {@inheritdoc}
     */
    public function getSubscriptionAction()
    { return $this->hasOne(UserSubscriptionAction::class, ['id' => 'action_id']); }

    /**
     * {@inheritdoc}
     *
     * @return UserSubscriptionActionQuery the active query used by this AR class.
     */
    public static function find()
    { return new UserSubscriptionActionQuery(get_called_class()); }

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
