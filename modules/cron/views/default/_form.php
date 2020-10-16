<?php

use rusbeldoor\yii2General\widgets\AddEditForm;
use kartik\sortinput\SortableInput;

/* @var $this yii\web\View */
/* @var $model backend\modules\administrator\modules\rbac\models\AuthItem */
/* @var $rolesNotOfThisRole array */
/* @var $rolesOfThisRole array */
/* @var $permissionsNotOfThisRole array */
/* @var $permissionsOfThisRole array */
?>

<div class="auth-item-form">
    <? $form = AddEditForm::begin() ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => 96]) ?>
    <?= $form->field($model, 'description')->textInput(['maxlength' => 192]) ?>
    <?= $form->buttons($model) ?>
    <? AddEditForm::end() ?>
</div>
