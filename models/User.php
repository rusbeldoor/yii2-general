<?php

namespace rusbeldoor\yii2General\models;

use yii;

/**
 * User (ActiveRecord)
 *
 * ...
 */
class User extends \rusbeldoor\yii2General\models\ActiveRecord implements yii\web\IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    { return 'user'; }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [/* ... */];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [/* ... */];
    }

    /**
     * {@inheritdoc}
     *
     * @return UserSubscriptionQuery the active query used by this AR class.
     */
    public static function find()
    { return new UserQuery(get_called_class()); }

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
