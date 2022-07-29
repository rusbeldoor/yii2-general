<?php

namespace rusbeldoor\yii2General\models;

/**
 * User_subscription_sender_category_action (ActiveRecord)
 *
 * @property int $id
 * @property int $category_id
 * @property string $alias
 * @property string $name
 * @property int $active
 */
class UserSubscriptionSenderCategoryAction extends ActiveRecord
{
    /** {@inheritdoc} */
    public static function tableName()
    { return 'user_subscription_sender_category_action'; }

    /** {@inheritdoc} */
    public function rules(): array
    { return [
        [['category_id', 'alias', 'name'], 'required'],
        [['category_id', 'active'], 'integer'],
        [['alias', 'part_key_alias', 'name'], 'string', 'max' => 128],
        [['alias'], 'unique'],
        [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserSubscriptionSenderCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
    ]; }

    /** {@inheritdoc} */
    public function attributeLabels(): array
    { return [
        'id' => 'Ид',
        'platform_id' => 'Платформа',
        'alias' => 'Алиас',
        'part_key_alias' => 'Часть алиаса ключа',
        'name' => 'Название',
        'active' => 'Активный',
    ]; }

    /**
     * {@inheritdoc}
     *
     * @return UserSubscriptionSenderCategoryActionQuery the active query used by this AR class.
     */
    public static function find()
    { return new UserSubscriptionSenderCategoryActionQuery(get_called_class()); }

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
