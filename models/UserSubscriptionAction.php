<?php

namespace rusbeldoor\yii2General\models;

/**
 * User_subscription_action (ActiveRecord)
 *
 * @property int $id
 * @property int $platform_id
 * @property string $alias
 * @property string $part_key_alias
 * @property string $name
 * @property int $active
 */
class UserSubscriptionAction extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    { return 'user_subscription_action'; }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['platform_id', 'alias', 'name'], 'required'],
            [['platform_id', 'active'], 'integer'],
            [['alias', 'part_key_alias', 'name'], 'string', 'max' => 128],
            [['alias'], 'unique'],
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
            'part_key_alias' => 'Часть алиаса ключа',
            'name' => 'Название',
            'active' => 'Активный',
        ];
    }

    /**
     * {@inheritdoc}
     *
     * @return UserSubscriptionActionQuery the active query used by this AR class.
     */
    public static function find()
    { return new UserSubscriptionActionQuery(get_called_class()); }

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
