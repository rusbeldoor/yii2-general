<?php

use rusbeldoor\yii2General\widgets\AddEditForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\admin\modules\rbac\models\AuthItem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="auth-item-form">
    <?php $form = AddEditForm::begin() ?>
        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'description') ?>
        <?= $form->buttons($model) ?>
    <?php AddEditForm::end() ?>
</div>
