<?php

/* @var $this yii\web\View */
/* @var $model backend\modules\administrator\modules\rbac\models\AuthItem */

$this->title = 'Добавление';
$this->params['breadcrumbs'][] = ['label' => 'Операции', 'url' => ['/administrator/rbac/permission']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
