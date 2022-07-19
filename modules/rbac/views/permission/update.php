<?php
/**
 * @var yii\web\View $this
 * @var backend\modules\administrator\modules\rbac\models\AuthItem $model
 */

$this->title = $model->name;
$this->context->addBreadcrumb('Операции', ['/administrator/rbac/permission']);
$this->context->addBreadcrumb($model->name, ['view', 'id' => $model->id]);
$this->context->addBreadcrumb('Изменение');
?>

<div class="auth-item-update">
    <?= $this->render('_form', ['model' => $model]) ?>
</div>
