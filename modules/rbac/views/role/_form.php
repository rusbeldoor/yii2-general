<?php

use rusbeldoor\yii2General\widgets\AddEditForm;
use kartik\sortinput\SortableInput;

/* @var yii\web\View $this */
/* @var backend\modules\administrator\modules\rbac\models\AuthItem $model */
/* @var array $rolesNotOfThisRole */
/* @var array $rolesOfThisRole */
/* @var array $permissionsNotOfThisRole */
/* @var array $permissionsOfThisRole */
?>

<div class="auth-item-form">
    <? $form = AddEditForm::begin() ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => 96]) ?>
        <?= $form->field($model, 'description')->textInput(['maxlength' => 192]) ?>
        <div class="form-group row">
            <label class="col-form-label col-md-2">Роли</label>
            <div class="col-md-5">
                <?= SortableInput::widget([
                    'name' => 'roles-names',
                    'items' => $rolesNotOfThisRole,
                    'sortableOptions' => [
                        'itemOptions' => ['class' => 'alert alert-secondary'],
                        'connected' => 'roles',
                    ],
                    'options' => ['class' => 'form-control', 'readonly' => true]
                ]) ?>
            </div>
            <div class="col-md-5">
                <?= SortableInput::widget([
                    'name' => 'child-roles-names',
                    'items' => $rolesOfThisRole,
                    'sortableOptions' => [
                        'itemOptions' => ['class' => 'alert alert-success'],
                        'connected' => 'roles',
                    ],
                    'options' => ['class' => 'form-control', 'readonly' => true]
                ]) ?>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-md-2">Операции</label>
            <div class="col-md-5">
                <?= SortableInput::widget([
                    'name' => 'permissions-names',
                    'items' => $permissionsNotOfThisRole,
                    'sortableOptions' => [
                        'itemOptions' => ['class' => 'alert alert-secondary'],
                        'connected' => 'permissions',
                    ],
                    'options' => ['class' => 'form-control', 'readonly' => true]
                ]) ?>
            </div>
            <div class="col-md-5">
                <?= SortableInput::widget([
                    'name' => 'child-permissions-names',
                    'items' => $permissionsOfThisRole,
                    'sortableOptions' => [
                        'itemOptions' => ['class' => 'alert alert-success'],
                        'connected' => 'permissions',
                    ],
                    'options' => ['class' => 'form-control', 'readonly' => true]
                ]) ?>
            </div>
        </div>
        <?= $form->buttons($model) ?>
    <? AddEditForm::end() ?>
</div>
