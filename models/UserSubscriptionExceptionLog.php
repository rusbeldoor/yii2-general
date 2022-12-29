<?php

namespace rusbeldoor\yii2General\models;

/**
 * User_subscription_log (ActiveRecord)
 *
 * @property int $id
 * @property int $exception_id
 * @property int $time
 * @property string $date
 *
 * @property UserSubscriptionSender $subscription
 */
class UserSubscriptionExemptionLog extends ActiveRecord
{
    /** {@inheritdoc} */
    public static function tableName()
    { return 'user_subscription_log'; }

    /** {@inheritdoc} */
    public function rules(): array
    { return [
        [['exception_id', 'time'], 'required'],
        [['exception_id', 'time'], 'integer', 'min' => 0],
        [['date'], 'default', 'value' => null],
        [['exception_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserSubscriptionExemption::className(), 'targetAttribute' => ['exception_id' => 'id']],
    ]; }

    /** {@inheritdoc} */
    public function getSubscription()
    { return $this->hasOne(UserSubscriptionExemption::class, ['id' => 'exception_id']); }

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
     * @return UserSubscriptionExemptionLogQuery the active query used by this AR class.
     */
    public static function find()
    { return new UserSubscriptionExemptionLogQuery(get_called_class()); }

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