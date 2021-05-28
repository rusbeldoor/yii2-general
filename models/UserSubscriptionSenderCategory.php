<?php

namespace rusbeldoor\yii2General\models;

/**
 * User_subscription_sender_category (ActiveRecord)
 *
 * @property int $id
 * @property int $platform_id
 * @property string $alias
 * @property string $name
 *
 * @property Platform $platform
 * @property UserSubscriptionSenderCategoryAction[] $actions
 */
class UserSubscriptionSenderCategory extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName() { return 'user_subscription_sender_category'; }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['platform_id, alias, name'], 'required'],
            [['platform_id'], 'integer'],
            [['platform_id'], 'exist', 'skipOnError' => true, 'targetClass' => Platform::className(), 'targetAttribute' => ['platform_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Ид',
            'platform_id' => 'Платформа',
            'alias' => 'Алиас',
            'name' => 'Действие',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getPlatform()
    { return $this->hasOne(Platform::class, ['id' => 'platform_id']); }

    /**
     * {@inheritdoc}
     */
    public function getActions()
    { return $this->hasMany(UserSubscriptionSenderCategoryAction::class, ['category_id' => 'id']); }

    /**
     * {@inheritdoc}
     *
     * @return UserSubscriptionSenderCategoryActionQuery the active query used by this AR class.
     */
    public static function find()
    { return new UserSubscriptionSenderCategoryQuery(get_called_class()); }
}
