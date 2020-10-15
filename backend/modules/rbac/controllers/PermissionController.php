<?php

namespace rusbeldoor\yii2General\backend\modules\rbac\controllers;

use rusbeldoor\yii2General\helpers\AppHelper;
use yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use rusbeldoor\yii2General\common\models\AuthItem;
use rusbeldoor\yii2General\backend\modules\rbac\models\AuthItemSearch;

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
        if (Yii::$app->controller->module->onlyMigrations) {
            return AppHelper::redirectWitchFlash(
                '/administrator/rbac/permission',
                'error',
                'Создание операций разрешено только через миграции.'
            );
        }

        $model = new AuthItem();
        $model->type = 2;

        if (
            $model->load(Yii::$app->request->post())
            && $model->save()
        ) { return $this->redirect(['view', 'id' => $model->id]); }

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
        if (Yii::$app->controller->module->onlyMigrations) {
            return AppHelper::redirectWitchFlash(
                '/administrator/rbac/permission',
                'error',
                'Изменение операций разрешено только через миграции.'
            );
        }

        $model = $this->findModel($id);

        if (
            $model->load(Yii::$app->request->post())
            && $model->save()
        ) { return $this->redirect(['view', 'id' => $model->id]); }

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
        if (Yii::$app->controller->module->onlyMigrations) {
            return AppHelper::redirectWitchFlash(
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
