<?php
/**
 * This is the template for generating a CRUD controller class file.
 */

use yii\db\ActiveRecordInterface;
use yii\helpers\StringHelper;

/* @var yii\web\View $this */
/* @var yii\gii\generators\crud\Generator $generator */

$controllerClass = StringHelper::basename($generator->controllerClass);
$modelClass = StringHelper::basename($generator->modelClass);
$searchModelClass = StringHelper::basename($generator->searchModelClass);
if ($modelClass === $searchModelClass) {
    $searchModelAlias = $searchModelClass . 'Search';
}

/* @var ActiveRecordInterface $class */
$class = $generator->modelClass;
$pks = $class::primaryKey();
$urlParams = $generator->generateUrlParams();
$actionParams = $generator->generateActionParams();
$actionParamComments = $generator->generateActionParamComments();

$baseClass = explode('\\', $generator->controllerClass);
switch ($baseClass[0]) {
    case 'backend': $baseClass = '\backend\components\Controller'; break;
    case 'frontend': $baseClass = '\frontend\components\Controller'; break;
    case 'console': $baseClass = '\console\components\Controller'; break;
    default: $baseClass = '\rusbeldoor\yii2General\components\WebController'; break;
}

echo "<?php\n";
?>

namespace <?= StringHelper::dirname(ltrim($generator->controllerClass, '\\')) ?>;

use yii;
<?php if (empty($generator->searchModelClass)): ?>use yii\data\ActiveDataProvider;
<?php endif; ?>
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use <?= ltrim($generator->modelClass, '\\') ?>;
<?php if (!empty($generator->searchModelClass)): ?>use <?= ltrim($generator->searchModelClass, '\\') . (isset($searchModelAlias) ? " as $searchModelAlias" : "") ?>;
<?php endif; ?>

/**
 * <?= $controllerClass . "\n" ?>
 */
class <?= $controllerClass ?> extends <?= $baseClass . "\n" ?>
{
    /** {@inheritdoc} */
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
<?php if (!empty($generator->searchModelClass)): ?>
        $searchModel = new <?= isset($searchModelAlias) ? $searchModelAlias : $searchModelClass ?>();
        $dataProvider = $searchModel->search(Yii::$app->request->post());

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
<?php else: ?>
        $dataProvider = new ActiveDataProvider(['query' => <?= $modelClass ?>::find()]);

        return $this->render('index', ['dataProvider' => $dataProvider]);
<?php endif; ?>
    }

    /**
     * Просмотр
     *
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView(<?= $actionParams ?>)
    {
        return $this->render('view', ['model' => $this->findModel(<?= $actionParams ?>)]);
    }

    /**
     * Создание
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new <?= $modelClass ?>();

        if (
            $model->load(Yii::$app->request->post())
            && $model->save()
        ) { return $this->redirect(['view', <?= $urlParams ?>]); }

        return $this->render('create', ['model' => $model]);
    }

    /**
     * Изменение
     *
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(<?= $actionParams ?>)
    {
        $model = $this->findModel(<?= $actionParams ?>);

        if (
            $model->load(Yii::$app->request->post())
            && $model->save()
        ) { return $this->redirect(['view', <?= $urlParams ?>]); }

        return $this->render('update', ['model' => $model]);
    }

    /**
     * Получение модели
     *
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return <?=                   $modelClass ?> the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(<?= $actionParams ?>)
    {
<?php
if (count($pks) === 1) {
    $condition = '$id';
} else {
    $condition = [];
    foreach ($pks as $pk) { $condition[] = "'$pk' => \$$pk"; }
    $condition = '[' . implode(', ', $condition) . ']';
}
?>
        if (($model = <?= $modelClass ?>::findOne(<?= $condition ?>)) !== null) { return $model; }

        throw new NotFoundHttpException(<?= $generator->generateString('The requested page does not exist.') ?>);
    }
}
