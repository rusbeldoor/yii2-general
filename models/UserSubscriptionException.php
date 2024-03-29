<?php

namespace rusbeldoor\yii2General\models;

/**
 * User_subscription_exception (ActiveRecord)
 *
 * @property int $id
 * @property int $subscription_id
 * @property int $sender_category_action_id
 * @property int $channel_id
 * @property int $active
 */
class UserSubscriptionException extends ActiveRecord
{
    /** {@inheritdoc} */
    public static function tableName() { return 'user_subscription_exception'; }

    /** {@inheritdoc} */
    public function rules(): array
    { return [
        [['subscription_id', 'sender_category_action_id', 'channel_id'], 'required'],
        [['subscription_id', 'sender_category_action_id', 'channel_id', 'active'], 'integer', 'min' => 0],
    ]; }

    /** {@inheritdoc} */
    public function attributeLabels(): array
    { return [
        'id' => 'Ид',
        'subscription_id' => 'Подписка',
        'sender_category_action_id' => 'Действие отправителя',
        'channel_id' => 'Канал',
        'active' => 'Активный',
    ]; }

    /** {@inheritdoc} */
    public function getSubscription()
    { return $this->hasOne(UserSubscription::class, ['id' => 'subscription_id']); }

    /** {@inheritdoc} */
    public function getSubscriptionChannel()
    { return $this->hasOne(UserSubscriptionChannel::class, ['id' => 'channel_id']); }

    /** {@inheritdoc} */
    public function getSubscriptionAction()
    { return $this->hasOne(UserSubscriptionSenderCategoryAction::class, ['id' => 'sender_category_action_id']); }

    /**
     * {@inheritdoc}
     *
     * @return UserSubscriptionSenderCategoryActionQuery the active query used by this AR class.
     */
    public static function find()
    { return new ActiveQuery(get_called_class()); }

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