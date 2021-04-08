<?php

use rusbeldoor\yii2General\widgets\grid\GridView;
use rusbeldoor\yii2General\helpers\BaseUI;

/* @var yii\web\View $this */
/* @var backend\modules\administrator\modules\rbac\models\AuthItemSearch $searchModel */
/* @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Роли';
$this->params['breadcrumbs'][] = $this->title;

$buttonsForIndexPage = ['filter', 'add', 'delete'];
$gridViewColumns = [
    ['class' => 'rusbeldoor\yii2General\widgets\grid\BulkActionColumn'],
    'id:id',
    'name',
    'description',
    ['class' => 'rusbeldoor\yii2General\widgets\grid\ActionColumn'],
];
if (Yii::$app->controller->module->onlyMigrations) {
    unset($buttonsForIndexPage[array_search('add', $buttonsForIndexPage)]);
    unset($buttonsForIndexPage[array_search('delete', $buttonsForIndexPage)]);
    unset($gridViewColumns[0]);
    $actionColumn = array_pop($gridViewColumns);
    $actionColumn['template'] = '{view}';
    $gridViewColumns[] = $actionColumn;
}
?>
<div class="auth-item-index">
    <?= BaseUI::buttonsForIndexPage($buttonsForIndexPage) ?>

    <?= $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridViewColumns,
    ]); ?>
</div>
