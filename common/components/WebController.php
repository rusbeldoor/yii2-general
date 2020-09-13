<?php

namespace rusbeldoor\yii2General\common\components;

use yii;
use rusbeldoor\yii2General\common\helpers\AppHelper;

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
     * Архивация
     * backend\widgets\ArchiveActionColumn
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
