<?php
namespace rusbeldoor\yii2General\models;

use Yii;

/**
 * Cron (ActiveRecord)
 *
 * @property $id int
 * @property $alias string
 * @property $description string
 * @property $status string
 * @property $max_duration int|null
 * @property $kill_process int
 * @property $restart int
 * @property $active int
 */
class Cron extends ActiveRecord
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
            [['max_duration', 'restart', 'kill_process', 'active'], 'integer'],
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
            'restart' => 'Перезапуск после превышения максимальной продолжительности',
            'kill_process' => 'Уничтожить процесс после превышения максимальной продолжительности',
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
        // if (true) { $this->addError('id', 'Не возможно удалить #' . $this->id . '.'); }

        return !$this->hasErrors() && parent::beforeDelete();
    }
}
