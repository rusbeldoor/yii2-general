<?php
namespace rusbeldoor\yii2General\components;

use Yii;
use rusbeldoor\yii2General\models\Cron;
use rusbeldoor\yii2General\models\CronLog;

/**
 * Контроллер
 */
class CronController extends ConsoleController
{
    public $cron = null;
    public $cronLog = null;

    /**
     * Вызов перед экшеном
     *
     * @param $action
     * @return mixed
     */
    public function beforeAction($action)
    {
        // Текущее время
        $time = time();

        // Алиас крона
        $alias = Yii::$app->controller->id;

        // Крон
        $this->cron = Cron::find()->alias($alias)->one();

        // Если крона нет
        if (!$this->cron) {
            // Создаём крон
            $this->cron = new Cron();
            $this->cron->alias = $alias;
        }

        // Если крон не активен
        if (!$this->cron->active) { return false; }

        // Если предыдущий запуск крона еще не завершился
        if ($this->cron->status == 'process') {
             // Если лог предыдущего запуска крона найден
            if ($cronLog = CronLog::find()->cron($this->cron->id)->lastStart()->notComplete()->one()) {
                if (
                    // Если крон имеет максимальную продолжительность выполнения
                    ($this->cron->max_duration != null)
                    // Если крон выполняется дольше своей максимальной продолжительности выполнения
                    && (($time - strtotime($cronLog->datetime_start)) > $this->cron->max_duration)
                ) {
                    // todo: оповещаем о проблемах

                    // Если разрешено уничтожать предыдущий зависший процесс
                    if ($this->cron->kill_process) {
                        // Уничтожаем предыдущий зависший процесс
                        posix_kill($cronLog->pid, 'SIGKILL');
                    }

                    // Если не разрешено перезапускатся при предыдущем зависшем процессе
                    if (!$this->cron->restart) { return false; }
                }
            } else {
                // todo: оповещаем о проблемах

                return false;
            }
        }

        $this->cron->status = 'process';
        $this->cron->save();

        // Создаём лог крона
        $this->cronLog = new CronLog();
        $this->cronLog->cron_id = $this->cron->id;
        $this->cronLog->pid = getmypid(); // Запоминаем pid текущего процесса в linux
        $this->cronLog->datetime_start = date('Y-m-d H:i:s', $time);
        $this->cronLog->save();

        return parent::beforeAction($action);
    }

    /**
     * Вызов после экшена
     *
     * @param $action
     * @param $result
     * @return mixed\
     */
    public function afterAction($action, $result)
    {
        // Текущее время
        $time = time();

        // Обновляем крон
        $this->cron->status = 'wait';
        $this->cron->update();

        // Обновляем лог крона
        $this->cronLog->pid = null;
        $this->cronLog->duration = $time - strtotime($this->cronLog->datetime_start);
        $this->cronLog->datetime_complete = date('Y-m-d H:i:s', $time);
        $this->cronLog->update();

        return parent::afterAction($action, $result);
    }
}
