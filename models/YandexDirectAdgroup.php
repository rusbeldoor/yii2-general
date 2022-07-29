<?php

namespace rusbeldoor\yii2General\models;

/**
 * Yandex_direct_adgroup (ActiveRecord)
 *
 * @property $id int
 * @property $account_id int
 * @property $campaign_id int
 * @property $name string
 * @property $status string
 */
class YandexDirectAdgroup extends ActiveRecord
{
    /** {@inheritdoc} */
    public static function tableName()
    { return 'yandex_direct_adgroup'; }

    /** {@inheritdoc} */
    public function rules()
    {
        return [
            [['id', 'account_id', 'campaign_id', 'name', 'status'], 'required'],
            [['account_id'], 'integer'],
            [['id', 'campaign_id', 'status'], 'string', 'max' => 16],
            [['name'], 'string', 'max' => 128],
            [['id'], 'unique'],
            [['account_id'], 'exist', 'skipOnError' => true, 'targetClass' => YandexDirectAccount::className(), 'targetAttribute' => ['account_id' => 'id']],
            [['campaign_id'], 'exist', 'skipOnError' => true, 'targetClass' => YandexDirectCampaign::className(), 'targetAttribute' => ['campaign_id' => 'id']],
        ];
    }

    /** {@inheritdoc} */
    public function attributeLabels()
    {
        return [
            'id' => 'Ид',
            'account_id' => 'Аккаунт',
            'campaign_id' => 'Компания',
            'name' => 'Название',
            'status' => 'Статус',
        ];
    }

    /**
     * {@inheritdoc}
     *
     * @return YandexDirectAdgroupQuery the active query used by this AR class.
     */
    public static function find()
    { return new YandexDirectAdgroupQuery(get_called_class()); }

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
