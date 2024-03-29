<?php

namespace rusbeldoor\yii2General\components;

use Yii;
use rusbeldoor\yii2General\helpers\AppHelper;

/**
 * Контроллер
 */
class WebController extends \yii\web\Controller
{
    public \yii\web\Application $yiiApp;

    /**
     * Инициализация
     *
     * @return void
     */
    public function init()
    {
        parent::init();

        $this->yiiApp = Yii::$app;

        // Объявлении версии bootstrap для kartik-v вендора
        Yii::$app->params['bsVersion'] = '5.x';
    }

    /**** Общие действия ***/

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
            if (isset($post['items'])) { $ids = explode(',', $post['items']); }
        }

        // id удалённых элементов
        $deletedIds = [];
        // id не удалённых элементов
        $notDeletedIds = [];

        // Перебираем id удаляемых элемнетов
        foreach ($ids as $id) {
            // Получаем модель
            $model = $this->findModel($id);
            // Пытаемся удалить элемент
            $result = $model->delete();
            // Если ошибок при удалении нет
            if (!$model->hasErrors()) { $deletedIds[] = $id; }
            else { $notDeletedIds[$id] = $model->getErrorSummary(true); }
        }

        // Если есть удалённые элементы
        if (count($deletedIds)) {
            $flashs['success'] = 'Элементы #' . implode(', #', $deletedIds) . ' удалены.';
        }

        // Если есть не удалённые элементы
        if (count($notDeletedIds)) {
            $notDeletedErrors = '';
            foreach ($notDeletedIds as $id => $errors) { $notDeletedErrors .= '<li>' . implode('</li><li>', $errors) . '</li>'; }
            $flashs[((count($deletedIds)) ? 'warning' : 'error')] = 'Не удалось удалить' . ((count($deletedIds)) ? ' некоторые' : '') . ' элементы:<ul>' . $notDeletedErrors . '</ul>';
        }

        AppHelper::setFlashes($flashs);

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

    /*** Свои методы ***/

    /**
     * Добавление хлебной крошки
     *
     * @param string $label
     * @param ?array $url
     * @return void
     */
    public function addBreadcrumb(string $label, array $url = null)
    {
        $array = ['label' => $label];
        if ($url !== null) { $array['url'] = $url; }
        $this->view->params['breadcrumbs'][] = $array;
    }

    /*** Изменение родителських методов ***/

    /**
     * Returns the route of the current request.
     * @return string the route (module ID, controller ID and action ID) of the current request.
     */
    public function getRoute()
    {
        return ((($this->action !== null) && ($this->action->id !== 'index')) ? $this->action->getUniqueId() : $this->getUniqueId());
    }
}
