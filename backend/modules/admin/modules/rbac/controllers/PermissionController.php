<?php

namespace rusbeldoor\yii2General\backend\modules\admin\modules\rbac\controllers;

use yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use rusbeldoor\yii2General\backend\modules\admin\modules\rbac\models\AuthItem;
use rusbeldoor\yii2General\backend\modules\admin\modules\rbac\models\AuthItemSearch;

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
     * @param $name string
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($name)
    {
        return $this->render('view', ['model' => $this->findModel($name)]);
    }

    /**
     * Создание
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AuthItem();
        $model->type = 2;
        $model->datetime_create = $model->datetime_update = date('Y-m-d H:i:s');

        if (
            $model->load(Yii::$app->request->post())
            && $model->save()
        ) { return $this->redirect(['view', 'name' => $model->name]); }

        return $this->render('create', ['model' => $model]);
    }

    /**
     * Изменение
     *
     * @param $name string
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($name)
    {
        $model = $this->findModel($name);

        if (
            $model->load(Yii::$app->request->post())
            && $model->save()
        ) { return $this->redirect(['view', 'name' => $model->name]); }

        return $this->render('update', ['model' => $model]);
    }

    /**
     * Получение модели
     *
     * @param $name string
     * @return AuthItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($name)
    {
        if (($model = AuthItem::findOne($name)) !== null) { return $model; }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
