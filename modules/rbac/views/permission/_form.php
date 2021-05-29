<?php

use rusbeldoor\yii2General\widgets\AddOrEditForm;

/* @var yii\web\View $this */
/* @var backend\modules\administrator\modules\rbac\models\AuthItem $model */
?>

<div class="auth-item-form">
    <?php $form = AddOrEditForm::begin() ?>
        <?= $form->errorSummary($model); ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => 96]) ?>
        <?= $form->field($model, 'description')->textInput(['maxlength' => 192]) ?>
        <?= $form->buttons($model) ?>
    <?php AddOrEditForm::end() ?>
</div>
