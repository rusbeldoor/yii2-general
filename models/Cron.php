<?php

namespace rusbeldoor\yii2General\models;

use yii;

/**
 * Cron (ActiveRecord)
 *
 * @property $id int
 * @property $alias string
 * @property $description string
 * @property $status string
 * @property $max_duration int|null
 * @property $kill_process_after_max_duration int
 * @property $restart_after_max_duration int
 * @property $active int
 */
class Cron extends \rusbeldoor\yii2General\models\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    { return 'cron'; }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['alias', 'description'], 'required'],
            [['description', 'status'], 'string'],
            [['max_duration', 'restart_after_max_duration', 'kill_process_after_max_duration', 'active'], 'integer'],
            [['alias'], 'string', 'max' => 96],
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
            'description' => 'Описание',
            'status' => 'Статус',
            'max_duration' => 'Максимальная продолжительность',
            'restart_after_max_duration' => 'Перезапуск после превышения максимальной продолжительности',
            'kill_process_after_max_duration' => 'Уничтожить процесс после превышения максимальной продолжительности',
            'active' => 'Активный',
        ];
    }

    /**
     * {@inheritdoc}
     *
     * @return CronQuery the active query used by this AR class.
     */
    public static function find()
    { return new CronQuery(get_called_class()); }

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
