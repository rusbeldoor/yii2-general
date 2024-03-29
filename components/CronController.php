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
     * @param string $action
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
            echo "Крон \"" . $alias . "\" не найден\n";
            return false;
        }

        // Если крон не активен
        if (!$this->cron->active) {
            echo "Крон \"" . $this->cron->alias . "\" не активен\n";
            return false;
        }

        echo "Запуск крона \"" . $this->cron->alias . "\"\n";

        // Если предыдущий запуск крона ещё не завершился
        if ($this->cron->status == 'process') {
            echo "Предыдущий запуск крона ещё не завершился\n";

            // Предыдущий запуск крона
            $cronLog = CronLog::find()->cronId($this->cron->id)->lastStart()->notComplete()->one();
            if (!$cronLog) {
                echo "Перезапуск крона запрещён (предыдущий запуск крона не найден)\n";

                // todo: оповещаем о проблемах

                return false;
            }

            $duration = $time - strtotime($cronLog->datetime_start);
            if (
                // Если крон имеет максимальную продолжительность выполнения
                ($this->cron->max_duration != null)
                // Если крон выполняется дольше своей максимальной продолжительности выполнения
                && ($duration <= $this->cron->max_duration)
            ) {
                echo "Перезапуск крона запрещён (предыдущий запуск крона выполняется меньше своей максимальной продолжительности)\n";
                echo "Повторите запуск через " . ($this->cron->max_duration - $duration)  . " сек.\n";

                // todo: оповещаем о проблемах

                return false;
            }

            echo "Предыдущий запуск крона выполняется дольше своей максимальной продолжительности\n";

            // todo: оповещаем о проблемах

            // Если разрешено уничтожать предыдущий зависший процесс
            if ($this->cron->kill_process) {
                // Если функция posix_kill доступна
                if (function_exists('posix_kill')) {
                    echo "Уничтожаем процесс " . $cronLog->pid . " отвечающий за предыдущий запуск крона\n";

                    // Уничтожаем предыдущий зависший процесс
                    posix_kill($cronLog->pid, 9); // SIGKILL
                } else {
                    echo "Функция posix_kill не доступна, процесс отвечающий за предыдущий запуск крона не уничтожить\n";
                }
            }

            // Если не разрешено перезапускаться
            if (!$this->cron->restart) {
                echo "Перезапуск крона запрещён\n";
                return false;
            }
        }

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

        echo "<--- Начало выполнения --->\n";

        return parent::beforeAction($action);
    }

    /**
     * Вызов после экшена
     *
     * @param string $action
     * @param mixed $result
     * @return mixed
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

        echo "<--- Конец выполнения (" . $this->cronLog->duration . " сек.) --->\n";

        return parent::afterAction($action, $result);
    }
}
