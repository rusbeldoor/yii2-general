<?php

namespace rusbeldoor\yii2General\models;

/**
 * Yandex_direct_log (ActiveRecord)
 *
 * @property $id int
 * @property $user_id int|null
 * @property $elem_type string
 * @property $elem_id string
 * @property $datetime string
 * @property $action string
 */
class YandexDirectLog extends ActiveRecord
{
    // Описание полей
    public static $fieldsDescriptions = [
        'action' => [
            'resume' => 'Запуск',
            'suspend' => 'Остановка',
            'unarchive' => 'Разархивация',
            'archive' => 'Архивация',
        ],
    ];

    /** {@inheritdoc} */
    public static function tableName()
    { return 'yandex_direct_log'; }

    /** {@inheritdoc} */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['elem_type', 'elem_id', 'datetime', 'action'], 'required'],
            [['elem_type'], 'string'],
            [['datetime'], 'safe'],
            [['elem_id'], 'string', 'max' => 16],
            [['action'], 'string', 'max' => 32],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /** {@inheritdoc} */
    public function attributeLabels()
    {
        return [
            'id' => 'Ид',
            'user_id' => 'Пользователь',
            'elem_type' => 'Тип элемента',
            'elem_id' => 'Элемент',
            'datetime' => 'Дата и время',
            'action' => 'Действие',
        ];
    }

    /**
     * {@inheritdoc}
     *
     * @return YandexDirectLogQuery the active query used by this AR class.
     */
    public static function find()
    { return new YandexDirectLogQuery(get_called_class()); }

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