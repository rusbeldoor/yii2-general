<?php

namespace rusbeldoor\yii2General\modules\rbac\controllers;

use yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use rusbeldoor\yii2General\models\AuthItem;
use rusbeldoor\yii2General\modules\rbac\models\AuthItemSearch;
use rusbeldoor\yii2General\helpers\AppHelper;

/**
 * PermissionController
 */
class PermissionController extends \backend\components\Controller
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
        $searchModel = new AuthItemSearch();
        $searchModel->type = 2;
        $dataProvider = $searchModel->search(Yii::$app->request->post());

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Просмотр
     *
     * @param $id string
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', ['model' => $this->findModel($id)]);
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
                '/administrator/rbac/permission',
                'error',
                'Создание операций разрешено только через миграции.'
            );
        }

        $model = new AuthItem();
        $model->type = 2;

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->load($post) && $model->save()) { return $this->redirect(['view', 'id' => $model->id]); }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', ['model' => $model]);
    }

    /**
     * Изменение
     *
     * @param $id string
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if ($this->module->onlyMigrations) {
            return AppHelper::redirectWithFlash(
                '/administrator/rbac/permission',
                'error',
                'Изменение операций разрешено только через миграции.'
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
     * @param $id int|null
     * @return yii\web\Response
     */
    public function actionDelete($id = null)
    {
        if ($this->module->onlyMigrations) {
            return AppHelper::redirectWithFlash(
                '/administrator/rbac/permission',
                'error',
                'Удаление операций разрешено только через миграции.'
            );
        }

        parent::actionDelete($id);
    }

    /**
     * Получение модели
     *
     * @param $id string
     * @return AuthItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AuthItem::findOne($id)) !== null) { return $model; }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
