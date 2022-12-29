<?php

namespace rusbeldoor\yii2General\models;

/**
 * User_subscription_log (ActiveRecord)
 *
 * @property int $id
 * @property int $subscription_id
 * @property int $time
 * @property string $date
 *
 * @property UserSubscriptionSender $subscription
 */
class UserSubscriptionLog extends ActiveRecord
{
    /** {@inheritdoc} */
    public static function tableName()
    { return 'user_subscription_log'; }

    /** {@inheritdoc} */
    public function rules(): array
    { return [
        [['subscription_id', 'time'], 'required'],
        [['subscription_id', 'time'], 'integer', 'min' => 0],
        [['date'], 'default', 'value' => null],
        [['subscription_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserSubscription::className(), 'targetAttribute' => ['subscription_id' => 'id']],
    ]; }

    /** {@inheritdoc} */
    public function getSubscription()
    { return $this->hasOne(UserSubscription::class, ['id' => 'subscription_id']); }

    /** {@inheritdoc} */
    public function attributeLabels(): array
    { return [
        'id' => 'Ид',
        'user_id' => 'Пользователь',
        'sender_id' => 'Отправитель',
        'date' => 'Данные',
    ]; }

    /**
     * {@inheritdoc}
     *
     * @return UserSubscriptionLogQuery the active query used by this AR class.
     */
    public static function find()
    { return new UserSubscriptionLogQuery(get_called_class()); }

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