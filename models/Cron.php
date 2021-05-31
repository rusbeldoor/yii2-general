<?php

namespace rusbeldoor\yii2General\models;

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
    // Описание полей
    public static $fieldsDescriptions = [
        'status' => [
            'wait' => 'Ожидает',
            'process' => 'Выполняется',
        ],
    ];

    protected $lastCronLog; // Последний лог

    /**
     * Магический метод получения аттрибута
     *
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        switch ($name) {
            case 'lastCronLog': $this->loadLastCronLog(); break;
            default:
        }
        return parent::__get($name);
    }

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
            'restart' => 'Перезапускать после превышения максимальной продолжительности',
            'kill_process' => 'Уничтожать предыдущий процесс после превышения максимальной продолжительности',
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
        // if (true) { $this->addError('id', 'Элемент #' . $this->id . ' не может быть удалён.'); }

        return !$this->hasErrors() && parent::beforeDelete();
    }

    /**
     * ...
     *
     * @param bool $force
     * @return void
     */
    private function loadLastCronLog($force = false)
    {
        if (!$this->lastCronLog || $force) {
            $this->lastCronLog = CronLog::find()->cronId($this->id)->lastStart()->one();
        }
    }
}
