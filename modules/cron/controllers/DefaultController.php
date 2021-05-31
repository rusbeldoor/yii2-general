<?php

namespace rusbeldoor\yii2General\modules\cron\controllers;

use yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use rusbeldoor\yii2General\models\Cron;
use rusbeldoor\yii2General\modules\cron\models\CronSearch;
use rusbeldoor\yii2General\modules\cron\models\CronLogSearch;
use rusbeldoor\yii2General\helpers\AppHelper;

/**
 * CronController
 */
class DefaultController extends \backend\components\Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => ['delete' => ['POST']],
            ],
        ];
    }

    /**
     * Список
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CronSearch();
        $searchModel->kill_process = '';
        $searchModel->restart = '';
        $searchModel->active = '';
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

        $cronLogSearch = new CronLogSearch();
        $cronLogSearch->cron_id = $id;
        $cronLogDataProvider = $cronLogSearch->search(Yii::$app->request->post());

        return $this->render(
            'view',
            [
                'model' => $model,
                'cronLogDataProvider' => $cronLogDataProvider,
            ]
        );
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
                '/administrator/cron',
                'error',
                'Создание кронов разрешено только через миграции.'
            );
        }

        $model = new Cron();

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->load($post) && $model->save()) { return $this->redirect(['index']); }
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
                '/administrator/cron',
                'error',
                'Изменение кроноа разрешено только через миграции.'
            );
        }

        $model = $this->findModel($id);

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->load($post) && $model->save()) { return $this->redirect(['view', 'id' => $model->id]); }
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
                '/administrator/cron',
                'error',
                'Удаление кронов разрешено только через миграции.'
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
        if (($model = Cron::findOne($id)) !== null) { return $model; }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
