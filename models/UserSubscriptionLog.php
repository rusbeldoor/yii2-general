<?php

namespace rusbeldoor\yii2General\models;

/**
 * User_subscription_log (ActiveRecord)
 *
 * @property int $id
 * @property int $subscription_id
 * @property int $time
 * @property int $user_id
 * @property string $action
 * @property string $data
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
        [['subscription_id', 'time', 'action'], 'required'],
        [['subscription_id', 'time', 'user_id'], 'integer', 'min' => 0],
        [['data', 'user_id'], 'default', 'value' => null],
        [['action'], 'in', 'range' => ['add', 'activate', 'deactivate']],
        [['subscription_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserSubscription::className(), 'targetAttribute' => ['subscription_id' => 'id']],
    ]; }

    /** {@inheritdoc} */
    public function getSubscription()
    { return $this->hasOne(UserSubscription::class, ['id' => 'subscription_id']); }

    /** {@inheritdoc} */
    public function attributeLabels(): array
    { return [
        'id' => 'Ид',
        'subscription_id' => 'Подписка',
        'time' => 'Дата и время',
        'user_id' => 'Пользователь',
        'action' => 'Действие',
        'data' => 'Данные',
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