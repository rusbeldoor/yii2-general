<?php

use rusbeldoor\yii2General\widgets\AddEditForm;
use kartik\sortinput\SortableInput;

/* @var $this yii\web\View */
/* @var $model backend\modules\admin\modules\rbac\models\AuthItem */
/* @var $rolesNotOfThisRole array */
/* @var $rolesOfThisRole array */
/* @var $permissionsNotOfThisRole array */
/* @var $permissionsOfThisRole array */
?>

<div class="auth-item-form">
    <? $form = AddEditForm::begin() ?>
        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'description') ?>
        <div class="form-group row">
            <label class="col-form-label col-md-2">Роли</label>
            <div class="col-md-5">
                <?= SortableInput::widget([
                    'name' => 'roles-ids',
                    'items' => $rolesNotOfThisRole,
                    'hideInput' => false,
                    'sortableOptions' => ['connected' => true],
                    'options' => ['class' => 'form-control', 'readonly' => true]
                ]) ?>
            </div>
            <div class="col-md-5">
                <?= SortableInput::widget([
                    'name' => 'child-roles-ids-',
                    'items' => $rolesOfThisRole,
                    'hideInput' => false,
                    'sortableOptions' => [
                        'itemOptions' => ['class' => 'alert alert-warning'],
                        'connected' => true,
                    ],
                    'options' => ['class' => 'form-control', 'readonly' => true]
                ]) ?>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-md-2">Операции</label>
            <div class="col-md-5">
                <?= SortableInput::widget([
                    'name' => 'permissions-ids',
                    'items' => $permissionsNotOfThisRole,
                    'hideInput' => false,
                    'sortableOptions' => ['connected' => true],
                    'options' => ['class' => 'form-control', 'readonly' => true]
                ]) ?>
            </div>
            <div class="col-md-5">
                <?= SortableInput::widget([
                    'name' => 'child-permissions-ids',
                    'items' => $permissionsOfThisRole,
                    'hideInput' => false,
                    'sortableOptions' => [
                        'itemOptions' => ['class' => 'alert alert-warning'],
                        'connected' => true,
                    ],
                    'options' => ['class' => 'form-control', 'readonly' => true]
                ]) ?>
            </div>
        </div>
        <?= $form->buttons($model) ?>
    <? AddEditForm::end() ?>
</div>
