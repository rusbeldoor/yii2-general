<?php
namespace rusbeldoor\yii2General\modules\rbac\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use rusbeldoor\yii2General\models\AuthItem;
use rusbeldoor\yii2General\modules\rbac\models\AuthItemSearch;
use rusbeldoor\yii2General\helpers\AppHelper;

use QuickService\general\common\models\QTOrganisation;

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
        $model = $this->findModel($id);

        $rolesOfThisRole = $permissionsOfThisRole = [];
        $elems = $model->find()->ofRole($model->name)->all();
        foreach ($elems as $elem) {
            if ($elem->isRole()) { $rolesOfThisRole[$elem->name] = ['content' => $elem->name]; }
            elseif ($elem->isPermission()) { $permissionsOfThisRole[$elem->name] = ['content' => $elem->name]; }
        }

        return $this->render(
            'view',
            [
                'model' => $model,
                'rolesOfThisRole' => $rolesOfThisRole,
                'permissionsOfThisRole' => $permissionsOfThisRole,
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
                '/administrator/rbac/role',
                'error',
                'Создание ролей разрешено только через миграции.'
            );
        }

        $model = new AuthItem();
        $model->type = 1;

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->load($post) && $model->save()) {
                $model->deleteAllChildren();
                $model->addChildren($post['child-roles-names']);
                $model->addChildren($post['child-permissions-names']);
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        $rolesNotOfThisRole = $permissionsNotOfThisRole = [];
        $elems = $model->find()->all();
        foreach ($elems as $elem) {
            if ($elem->isRole()) { $rolesNotOfThisRole[$elem->name] = ['content' => $elem->name]; }
            elseif ($elem->isPermission()) { $permissionsNotOfThisRole[$elem->name] = ['content' => $elem->name]; }
        }

        return $this->render(
            'create',
            [
                'model' => $model,
                'rolesNotOfThisRole' => $rolesNotOfThisRole,
                'rolesOfThisRole' => [],
                'permissionsNotOfThisRole' => $permissionsNotOfThisRole,
                'permissionsOfThisRole' => [],
            ]
        );
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
                '/administrator/rbac/role',
                'error',
                'Изменение ролей разрешено только через миграции.'
            );
        }

        $model = $this->findModel($id);

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->load($post) && $model->save()) {
                $model->deleteAllChildren();
                $model->addChildren($post['child-roles-names']);
                $model->addChildren($post['child-permissions-names']);
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        $rolesNotOfThisRole = $rolesOfThisRole = $permissionsNotOfThisRole = $permissionsOfThisRole = [];
        $elems = $model->find()->ofRole($model->name)->all();
        foreach ($elems as $elem) {
            if ($elem->isRole()) { $rolesOfThisRole[$elem->name] = ['content' => $elem->name]; }
            elseif ($elem->isPermission()) { $permissionsOfThisRole[$elem->name] = ['content' => $elem->name]; }
        }
        $elems = $model->find()->notOfRole($model->name)->all();
        foreach ($elems as $elem) {
            if ($elem->isRole()) { $rolesNotOfThisRole[$elem->name] = ['content' => $elem->name]; }
            elseif ($elem->isPermission()) { $permissionsNotOfThisRole[$elem->name] = ['content' => $elem->name]; }
        }

        return $this->render(
            'update',
            [
                'model' => $model,
                'rolesNotOfThisRole' => $rolesNotOfThisRole,
                'rolesOfThisRole' => $rolesOfThisRole,
                'permissionsNotOfThisRole' => $permissionsNotOfThisRole,
                'permissionsOfThisRole' => $permissionsOfThisRole,
            ]
        );
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
                '/administrator/rbac/role',
                'error',
                'Удаление ролей разрешено только через миграции.'
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
