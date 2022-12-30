<?php

namespace rusbeldoor\yii2General\models;

/**
 * User_subscription (ActiveRecord)
 *
 * @property int $id
 * @property int $user_id
 * @property int $sender_id
 * @property int $active
 *
 * @property UserSubscriptionSender $sender
 * @property UserSubscriptionException[] $exceptions
 */
class UserSubscription extends ActiveRecord
{
    /** {@inheritdoc} */
    public static function tableName()
    { return 'user_subscription'; }

    /** {@inheritdoc} */
    public function rules(): array
    { return [
        [['user_id', 'sender_id'], 'required'],
        [['user_id', 'sender_id', 'active'], 'integer', 'min' => 0],
        [['user_id', 'sender_id'], 'unique', 'targetAttribute' => ['user_id', 'sender_id']],
        [['sender_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserSubscriptionSender::className(), 'targetAttribute' => ['sender_id' => 'id']],
    ]; }

    /** {@inheritdoc} */
    public function getSender()
    { return $this->hasOne(UserSubscriptionSender::class, ['id' => 'sender_id']); }

    /** {@inheritdoc} */
    public function getExceptions()
    { return $this->hasMany(UserSubscriptionException::class, ['subscription_id' => 'id']); }

    /** {@inheritdoc} */
    public function attributeLabels(): array
    { return [
        'id' => 'Ид',
        'user_id' => 'Пользователь',
        'sender_id' => 'Отправитель',
        'active' => 'Активный',
    ]; }

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
