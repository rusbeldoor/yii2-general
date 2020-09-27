<?php

namespace rusbeldoor\yii2General\backend\modules\admin\modules\rbac\controllers;

use QuickService\general\common\models\QTOrganisation;
use yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use rusbeldoor\yii2General\backend\modules\admin\modules\rbac\models\AuthItem;
use rusbeldoor\yii2General\backend\modules\admin\modules\rbac\models\AuthItemSearch;
use rusbeldoor\yii2General\helpers\ArrayHelper;

/**
 * RoleController
 */
class RoleController extends \backend\components\Controller
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
        $searchModel->type = 1;
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
        $model = new AuthItem();
        $model->type = 1;

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
        //$this->redirect('/admin');

        $model = $this->findModel($id);

        if (
            $model->load(Yii::$app->request->post())
            && $model->save()
        ) { return $this->redirect(['view', 'id' => $model->id]); }

        return $this->render(
            'update',
            [
                'model' => $model,
                'rolesNotOfThisRole' => ArrayHelper::map(AuthItem::model()->find()->typeRole()->ofRole($model->name)->all(), 'id', 'name'),
                'rolesOfThisRole' => ArrayHelper::map(AuthItem::model()->find()->typeRole()->notOfRole($model->name)->all(), 'id', 'name'),
                'permissionsNotOfThisRole' => ArrayHelper::map(AuthItem::model()->find()->typePermission()->ofRole($model->name)->all(), 'id', 'name'),
                'permissionsOfThisRole' => ArrayHelper::map(AuthItem::model()->find()->typePermission()->notOfRole($model->name)->all(), 'id', 'name'),
            ]
        );
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
