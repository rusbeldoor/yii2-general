<?php
/**
 * @var yii\web\View $this
 * @var backend\modules\administrator\modules\rbac\models\AuthItem $model
 */

$this->title = 'Добавление';
$this->context->addBreadcrumb('Кроны', ['/administrator/cron']);
$this->context->addBreadcrumb('Добавление');
?>

<div class="auth-item-create">
    <?= $this->render('_form', ['model' => $model]) ?>
</div>
