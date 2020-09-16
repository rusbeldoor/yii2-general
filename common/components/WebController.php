<?php

namespace rusbeldoor\yii2General\common\components;

use yii;
use rusbeldoor\yii2General\helpers\AppHelper;

/**
 * Контроллер
 */
class WebController extends \yii\web\Controller
{
    /**
     * Returns the route of the current request.
     * @return string the route (module ID, controller ID and action ID) of the current request.
     */
    public function getRoute()
    {
        return ((($this->action !== null) && ($this->action->id !== 'index')) ? $this->action->getUniqueId() : $this->getUniqueId());
    }

    /**
     * Удаление
     *
     * @param int|null $id
     * @return yii\web\Response
     */
    public function actionDelete($id = null)
    {
        if (!Yii::$app->request->isPost) { return $this->redirect(['index']); }

        // Массив id удаляемых элементов
        $ids = [];
        if ($id !== null) { $ids[] = $id; }
        else {
            $post = Yii::$app->request->post();
            if (isset($post['items'])) {
                $ids = explode(',', $post['items']);
            }
        }

        $deletedIds = [];
        $notDeletedIds = [];

        // Перебираем id удаляемых элемнетов
        foreach ($ids as $id) {
            // Получаем модель
            $model = $this->findModel($id);
            // Проверяем возможность удаления
            $check = $model->checkCanDelete($id);
            if ($check['result']) {
                // Удаляем
                $model->delete();
                // Запоминаем id как удалённый
                $deletedIds[] = $id;
            } else {
                // Запоминаем id как не удалённый
                $notDeletedIds[$id] = $check['reason'];
            }
        }

        // Формируем результат
        $not_deleted_html = '';
        if (count($notDeletedIds)) {
            foreach ($notDeletedIds as $id => $reson) {
                $not_deleted_html .= '<br>#' . $id . ' — ' . $reson;
            }
        }
        if (count($deletedIds)) {
            $flashs['success'] = 'Элементы #' . implode(', #', $deletedIds) . ' успешно удалены.';
            $flashs['warning'] = 'Не удалось удалить некоторые элементы:' . $not_deleted_html;
        } else {
            $flashs['error'] = 'Не удалось удалить элементы:' . $not_deleted_html;
        }

        self::setFlashs($flashs);

        return $this->redirect(['index']);
    }

    /**
     * Архивация
     *
     * @return void
     */
    public function actionArchive()
    {
        AppHelper::exitIfNotAjaxRequest();
        AppHelper::exitIfNotPostRequest();

        // Загружаем модель
        $model = $this->findModel((int)Yii::$app->request->post('id'));

        // Если в модели не существует поля архив
        if (!isset($model->archive)) { AppHelper::exitWithJsonResult(false); }

        // Изменяем поле архив на противоположное значение
        $model->archive = (int)!$model->archive;
        $model->update();

        AppHelper::exitWithJsonResult(true);
    }
}
