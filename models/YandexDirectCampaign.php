<?php
namespace rusbeldoor\yii2General\models;

use Yii;

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
            [['name', 'status', 'state'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['status', 'state'], 'string', 'max' => 16],
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
        // if (true) { $this->addError('id', 'Неовзможно удалить #' . $this->id . '.'); }

        return !$this->hasErrors() && parent::beforeDelete();
    }
}
