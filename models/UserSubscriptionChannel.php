<?php
namespace rusbeldoor\yii2General\models;

use Yii;

/**
 * User_subscription_channel (ActiveRecord)
 *
 * @property $id int
 * @property $alias string
 * @property $name string
 */
class UserSubscriptionChannel extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    { return 'user_subscription_channel'; }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['alias', 'name'], 'required'],
            [['alias', 'name'], 'string', 'max' => 32],
            [['alias'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Ид',
            'alias' => 'Алиас',
            'name' => 'Название',
        ];
    }

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
        // if (true) { $this->addError('id', 'Неовзможно удалить #' . $this->id . '.'); }

        return !$this->hasErrors() && parent::beforeDelete();
    }
}
