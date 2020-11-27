<?php

use rusbeldoor\yii2General\widgets\AddEditForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\administrator\modules\rbac\models\AuthItem */
?>

<div class="auth-item-form">
    <?php $form = AddEditForm::begin() ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => 96, 'readonly' => !$model->isNewRecord()]) ?>
        <?= $form->field($model, 'description')->textInput(['maxlength' => 192]) ?>
        <?= $form->buttons($model) ?>
    <?php AddEditForm::end() ?>
</div>
