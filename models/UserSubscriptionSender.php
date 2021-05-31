<?php

namespace rusbeldoor\yii2General\models;

/**
 * User_subscription_sender (ActiveRecord)
 *
 * @property int $id
 * @property int $category_id
 * @property string $key
 * @property string $name
 * @property int $active
 */
class UserSubscriptionSender extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    { return 'user_subscription_sender'; }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'name', 'active'], 'required'],
            [['category_id', 'active'], 'integer'],
            [['name'], 'string', 'max' => 128],
            [['key'], 'string', 'max' => 16],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserSubscriptionSenderCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Ид',
            'category_id' => 'Категория',
            'key' => 'Ключ',
            'name' => 'Название',
            'active' => 'Активный',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getCategory()
    { return $this->hasOne(UserSubscriptionSenderCategory::class, ['id' => 'category_id']); }


    /**
     * {@inheritdoc}
     *
     * @return UserSubscriptionSenderQuery the active query used by this AR class.
     */
    public static function find()
    { return new UserSubscriptionSenderQuery(get_called_class()); }

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
