<?php

namespace rusbeldoor\yii2General\models;

/**
 * User_subscription_exemption_log (ActiveRecord)
 *
 * @property int $id
 * @property int $exception_id
 * @property int $time
 * @property int $user_id
 * @property string $action
 * @property string $data
 *
 * @property UserSubscriptionExemption $exception
 */
class UserSubscriptionExemptionLog extends ActiveRecord
{
    /** {@inheritdoc} */
    public static function tableName()
    { return 'user_subscription_exception_log'; }

    /** {@inheritdoc} */
    public function rules(): array
    { return [
        [['exception_id', 'time', 'action'], 'required'],
        [['exception_id', 'time', 'user_id'], 'integer', 'min' => 0],
        [['user_id', 'data'], 'default', 'value' => null],
        [['action'], 'in', 'range' => ['add', 'activate', 'deactivate']],
        [['exception_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserSubscriptionExemption::className(), 'targetAttribute' => ['exception_id' => 'id']],
    ]; }

    /** {@inheritdoc} */
    public function getException()
    { return $this->hasOne(UserSubscriptionExemption::class, ['id' => 'exception_id']); }

    /** {@inheritdoc} */
    public function attributeLabels(): array
    { return [
        'id' => 'Ид',
        'exception_id' => 'Исключение из подписки',
        'time' => 'Дата и время',
        'user_id' => 'Пользователь',
        'action' => 'Действие',
        'data' => 'Данные',
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