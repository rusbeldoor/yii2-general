<?php

namespace rusbeldoor\yii2General\models;

/**
 * User_subscription_channel (ActiveRecord)
 *
 * @property int $id
 * @property string $alias
 * @property string $name
 * @property int $active
 */
class UserSubscriptionChannel extends ActiveRecord
{
    /** {@inheritdoc} */
    public static function tableName()
    { return 'user_subscription_channel'; }

    /** {@inheritdoc} */
    public function rules(): array
    { return [
        [['alias', 'name'], 'required'],
        [['active'], 'integer'],
        [['alias', 'name'], 'string', 'max' => 32],
        [['alias'], 'unique'],
    ]; }

    /** {@inheritdoc} */
    public function attributeLabels(): array
    { return [
        'id' => 'Ид',
        'alias' => 'Алиас',
        'name' => 'Название',
        'active' => 'Активный',
    ]; }

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
        // if (true) { $this->addError('id', 'Элемент #' . $this->id . ' не может быть удалён.'); }

        return !$this->hasErrors() && parent::beforeDelete();
    }
}
