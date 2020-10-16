<?php

namespace rusbeldoor\yii2General\common\models;

use yii;

/**
 * User_subscription_key (ActiveRecord)
 *
 * @property $id int
 * @property $alias string
 * @property $name string
 */
class UserSubscriptionKey extends \rusbeldoor\yii2General\models\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    { return 'user_subscription_key'; }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['alias', 'name'], 'required'],
            [['alias', 'name'], 'string', 'max' => 128],
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
     * @return UserSubscriptionKeyQuery the active query used by this AR class.
     */
    public static function find()
    { return new UserSubscriptionKeyQuery(get_called_class()); }

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

    /**
     * Получение ид по алиасам
     *
     * @param $alias string
     * @return array
     */
    public function getIdsByAliases($alias)
    {
        $result = [];
        $userSubscriptionKeys = $this->find()->alias($alias)->all();
        foreach ($userSubscriptionKeys as $userSubscriptionKey) { $result[] = $userSubscriptionKey->id; }
        return $result;
    }
}
