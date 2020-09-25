<?php

/* @var $this yii\web\View */
/* @var $model backend\modules\admin\modules\rbac\models\AuthItem */

$this->title = 'Добавление';
$this->params['breadcrumbs'][] = ['label' => 'Auth Items', 'url' => ['/auth-item']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
