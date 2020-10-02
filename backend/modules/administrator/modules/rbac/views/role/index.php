<?php

use rusbeldoor\yii2General\widgets\grid\GridView;
use rusbeldoor\yii2General\helpers\BaseUI;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\administrator\modules\rbac\models\AuthItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Роли';
$this->params['breadcrumbs'][] = $this->title;

$buttonsForIndexPage = ['filter', 'add', 'delete'];
$gridViewColumns = [
    ['class' => 'rusbeldoor\yii2General\widgets\grid\BulkActionColumn'],
    'name',
    'description',
    ['class' => 'rusbeldoor\yii2General\widgets\grid\ActionColumn'],
];
if (Yii::$app->controller->module->onlyMigrations) {
    unset($buttonsForIndexPage[array_search('add', $buttonsForIndexPage)]);
    unset($buttonsForIndexPage[array_search('delete', $buttonsForIndexPage)]);
    unset($gridViewColumns[0]);
    $gridViewColumns[count($gridViewColumns) - 1]['template'] = '{view}';
}
?>
<div class="auth-item-index">
    <?= BaseUI::buttonsForIndexPage($buttonsForIndexPage) ?>

    <?= $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-striped table-hover'],
        'columns' => $gridViewColumns,
    ]); ?>
</div>
