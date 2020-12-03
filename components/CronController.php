<?php

namespace rusbeldoor\yii2General\components;

use yii;
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
            echo "Крон \"" . $alias . "\" не найден.\n";
            return false;
        }

        // Если крон не активен
        if (!$this->cron->active) {
            echo "Крон \"" . $this->cron->alias . "\" не активен.\n";
            return false;
        }

        echo "Крон \"" . $this->cron->alias . "\".\n";

        // Если предыдущий запуск крона ещё не завершился
        if ($this->cron->status == 'process') {
            echo "Предыдущий запуск крона ещё не завершился.\n";

             // Если лог предыдущего запуска крона найден
            if ($cronLog = CronLog::find()->cronId($this->cron->id)->lastStart()->notComplete()->one()) {
                if (
                    // Если крон имеет максимальную продолжительность выполнения
                    ($this->cron->max_duration != null)
                    // Если крон выполняется дольше своей максимальной продолжительности выполнения
                    && (($time - strtotime($cronLog->datetime_start)) > $this->cron->max_duration)
                ) {
                    echo "Предыдущий запуск крона выполняется дольше своей максимальной продолжитльности.\n";

                    // todo: оповещаем о проблемах

                    // Если разрешено уничтожать предыдущий зависший процесс
                    if ($this->cron->kill_process) {
                        echo "Уничтожаем процесс отвечающий за предыдущий запуск крона.\n";

                        // Уничтожаем предыдущий зависший процесс
                        posix_kill($cronLog->pid, 'SIGKILL');
                    }

                    // Если не разрешено перезапускаться при предыдущем зависшем процессе
                    if (!$this->cron->restart) {
                        echo "Перезапуск крона запрещён.\n";
                        return false;
                    }
                }
            } else {
                echo "Предыдущий запуск крона не найден.\n";

                // todo: оповещаем о проблемах

                return false;
            }
        }

        echo "Запуск крона --->\n";

        $this->cron->status = 'process';
        $this->cron->save();

        // Создаём лог крона
        $this->cronLog = new CronLog();
        $this->cronLog->cron_id = $this->cron->id;
        $this->cronLog->duration = null;
        $this->cronLog->datetime_start = date('Y-m-d H:i:s', $time);
        $this->cronLog->datetime_complete = null;
        $this->cronLog->pid = (string)getmypid(); // Запоминаем pid текущего процесса
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
        $this->cronLog->duration = $time - strtotime($this->cronLog->datetime_start);
        $this->cronLog->datetime_complete = date('Y-m-d H:i:s', $time);
        $this->cronLog->update();

        echo "<--- " . $this->cronLog->duration . " сек.\n\n";

        return parent::afterAction($action, $result);
    }
}
