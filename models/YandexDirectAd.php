<?php

namespace rusbeldoor\yii2General\models;

use yii;

/**
 * Yandex_direct_ad (ActiveRecord)
 *
 * @property $id int
 * @property $account_id int
 * @property $campaign_id int
 * @property $adgroup_id int
 * @property $title string
 * @property $status string
 * @property $state string
 */
class YandexDirectAd extends \rusbeldoor\yii2General\models\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    { return 'yandex_direct_ad'; }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'account_id', 'campaign_id', 'adgroup_id', 'title', 'status', 'state'], 'required'],
            [['account_id'], 'integer'],
            [['id', 'campaign_id', 'adgroup_id', 'status', 'state'], 'string', 'max' => 16],
            [['title'], 'string', 'max' => 128],
            [['id'], 'unique'],
            [['account_id'], 'exist', 'skipOnError' => true, 'targetClass' => YandexDirectAccount::className(), 'targetAttribute' => ['account_id' => 'id']],
            [['campaign_id'], 'exist', 'skipOnError' => true, 'targetClass' => YandexDirectCampaign::className(), 'targetAttribute' => ['campaign_id' => 'id']],
            [['adgroup_id'], 'exist', 'skipOnError' => true, 'targetClass' => YandexDirectAdgroup::className(), 'targetAttribute' => ['adgroup_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Ид',
            'account_id' => 'Аккаунт',
            'campaign_id' => 'Компания',
            'adgroup_id' => 'Группа объявлений',
            'title' => 'Заголовок',
            'status' => 'Статус',
            'state' => 'Состояние',
        ];
    }

    /**
     * {@inheritdoc}
     *
     * @return YandexDirectAdQuery the active query used by this AR class.
     */
    public static function find()
    { return new YandexDirectAdQuery(get_called_class()); }

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
