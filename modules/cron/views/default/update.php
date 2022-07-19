<?php
/**
 * @var yii\web\View $this
 * @var backend\modules\administrator\modules\rbac\models\AuthItem $model
 */

$this->title = $model->alias;
$this->context->addBreadcrumb('Кроны', ['/administrator/cron']);
$this->context->addBreadcrumb($model->alias, ['view', 'id' => $model->id]);
$this->context->addBreadcrumb('Изменение');
?>

<div class="auth-item-update">
    <?= $this->render('_form', ['model' => $model]) ?>
</div>
