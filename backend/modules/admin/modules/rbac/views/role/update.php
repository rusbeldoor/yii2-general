<?php

/* @var $this yii\web\View */
/* @var $model backend\modules\admin\modules\rbac\models\AuthItem */

$this->title = 'Update Auth Item: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Auth Items', 'url' => ['/auth-item']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->name]];
$this->params['breadcrumbs'][] = 'Изменение';
?>
<div class="auth-item-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
