<?php
/**
 * @var yii\web\View $this
 * @var backend\modules\administrator\modules\rbac\models\AuthItem $model
 */

$this->title = $model->alias;
$this->params['breadcrumbs'][] = ['label' => 'Платформы', 'url' => ['/administrator/platform']];
$this->params['breadcrumbs'][] = ['label' => $model->alias, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменение';
?>

<div class="auth-item-update">
    <?= $this->render('_form', ['model' => $model]) ?>
</div>
