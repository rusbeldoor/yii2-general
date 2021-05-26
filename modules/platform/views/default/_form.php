<?php

/* @var yii\web\View $this */
/* @var backend\modules\administrator\modules\rbac\models\AuthItem $model */

use rusbeldoor\yii2General\widgets\AddEditForm;
?>

<div class="auth-item-form">
    <? $form = AddEditForm::begin() ?>
        <?= $form->errorSummary($model); ?>
        <?= $form->field($model, 'alias')->textInput(['maxlength' => 16]) ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => 32]) ?>
        <?= $form->buttons($model) ?>
    <? AddEditForm::end() ?>
</div>
