<?php

use rusbeldoor\yii2General\widgets\AddEditForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\administrator\modules\rbac\models\AuthItem */
?>

<div class="auth-item-form">
    <? $form = AddEditForm::begin() ?>
    <?= $form->field($model, 'alias')->textInput(['maxlength' => 96]) ?>
    <?= $form->field($model, 'description')->textInput() ?>
    <?= $form->field($model, 'max_duration')->textInput() ?>
    <?= $form->field($model, 'kill_process')->numberYesNo() ?>
    <?= $form->field($model, 'restart')->numberYesNo() ?>
    <?= $form->buttons($model) ?>
    <? AddEditForm::end() ?>
</div>
