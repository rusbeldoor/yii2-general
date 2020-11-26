<?php

/* @var $this yii\web\View */
/* @var $model backend\modules\administrator\modules\rbac\models\AuthItem */

$this->title = $model->alias;
$this->params['breadcrumbs'][] = ['label' => 'Кроны', 'url' => ['/administrator/cron']];
$this->params['breadcrumbs'][] = ['label' => $model->alias, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменение';
?>
<div class="auth-item-update">
    <?= $this->render('_form', ['model' => $model]) ?>
</div>
