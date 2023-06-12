<?php

namespace rusbeldoor\yii2General\modules\platform\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use rusbeldoor\yii2General\models\platform;
use rusbeldoor\yii2General\modules\platform\models\platformSearch;
use rusbeldoor\yii2General\helpers\AppHelper;

/**
 * PlatformController
 */
class DefaultController extends \backend\components\Controller
{
    /** {@inheritdoc} */
    public function behaviors()
    { return [
        'verbs' => [
            'class' => VerbFilter::className(),
            'actions' => ['delete' => ['POST']],
        ],
    ]; }

    /**
     * Список
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PlatformSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->post());

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Просмотр
     *
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', ['model' => $model]);
    }

    /**
     * Создание
     *
     * @return mixed
     */
    public function actionCreate()
    {
        if ($this->module->onlyMigrations) {
            return AppHelper::redirectWithFlash(
                '/administrator/platform',
                'error',
                'Создание платформ разрешено только через миграции.'
            );
        }

        $model = new Platform();

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->load($post) && $model->save()) {
                return AppHelper::redirectIndexWithFlash('success', 'Платформа #' . $model->id . ' добавлена.');
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', ['model' => $model]);
    }

    /**
     * Изменение
     *
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if ($this->module->onlyMigrations) {
            return AppHelper::redirectWithFlash(
                '/administrator/platform',
                'error',
                'Изменение платформ разрешено только через миграции.'
            );
        }

        $model = $this->findModel($id);

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->load($post) && $model->save()) {
                return AppHelper::redirectIndexWithFlash('success', 'Платформа #' . $model->id . ' изменена.');
            }
        }

        return $this->render('update', ['model' => $model]);
    }

    /**
     * Удаление
     *
     * @param int|null $id
     * @return yii\web\Response
     */
    public function actionDelete($id = null)
    {
        if ($this->module->onlyMigrations) {
            return AppHelper::redirectWithFlash(
                '/administrator/зlatform',
                'error',
                'Удаление платформ разрешено только через миграции.'
            );
        }

        parent::actionDelete($id);
    }

    /**
     * Получение модели
     *
     * @param string $id
     * @return AuthItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Platform::findOne($id)) !== null) { return $model; }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
