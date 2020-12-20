<?php

namespace rusbeldoor\yii2General\models;

use yii;

/**
 * Yandex_direct_campaign (ActiveRecord)
 *
 * @property $id int
 * @property $name string
 * @property $status string
 * @property $state string
 */
class YandexDirectCampaign extends \rusbeldoor\yii2General\models\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    { return 'yandex_direct_campaign'; }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name', 'status', 'state'], 'required'],
            [['id', 'status', 'state'], 'string', 'max' => 16],
            [['name'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Ид',
            'name' => 'Название',
            'status' => 'Статус',
            'state' => 'State',
        ];
    }

    /**
     * {@inheritdoc}
     *
     * @return YandexDirectCampaignQuery the active query used by this AR class.
     */
    public static function find()
    { return new YandexDirectCampaignQuery(get_called_class()); }

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
