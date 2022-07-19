<?php
/**
 * @var yii\web\View $this
 * @var backend\modules\administrator\modules\rbac\models\AuthItem $model
 */

$this->title = 'Добавление';
$this->context->addBreadcrumb('Платформы', ['/administrator/platform']);
$this->context->addBreadcrumb('Добавление');
?>

<div class="auth-item-create">
    <?= $this->render('_form', ['model' => $model]) ?>
</div>
