<?php

/* @var yii\web\View $this */
/* @var backend\modules\administrator\modules\rbac\models\AuthItem $model */

$this->title = 'Добавление';
$this->params['breadcrumbs'][] = ['label' => 'Кроны', 'url' => ['/administrator/cron']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-create">
    <?= $this->render('_form', ['model' => $model]) ?>
</div>
