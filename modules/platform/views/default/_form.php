<?php

/* @var yii\web\View $this */
/* @var backend\modules\administrator\modules\rbac\models\AuthItem $model */

use rusbeldoor\yii2General\widgets\AddOrEditForm;
?>

<div class="auth-item-form">
    <? $form = AddOrEditForm::begin() ?>
        <?= $form->errorSummary($model); ?>
        <?= $form->field($model, 'alias')->alias(['maxlength' => 16])->hint('До 16 символов.') ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => 32])->hint('До 32 символов.') ?>
        <?= $form->buttons($model) ?>
    <? AddOrEditForm::end() ?>
</div>
