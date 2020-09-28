<?php

use rusbeldoor\yii2General\widgets\grid\GridView;
use rusbeldoor\yii2General\helpers\BaseUI;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\admin\modules\rbac\models\AuthItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Операции';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-index">
    <?= BaseUI::buttonsForIndexPage(['filter', 'add', 'delete']) ?>
    <?//= BaseUI::buttonsForIndexPage(['filter', 'add']) ?>

    <?= $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-striped table-hover'],
        'columns' => [
            ['class' => 'rusbeldoor\yii2General\widgets\grid\BulkActionColumn'],
            'name',
            'description',
            ['class' => 'rusbeldoor\yii2General\widgets\grid\ActionColumn'],
        ],
    ]); ?>
</div>
