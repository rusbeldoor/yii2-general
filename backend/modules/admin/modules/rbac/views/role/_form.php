<?php

use rusbeldoor\yii2General\widgets\AddEditForm;
use kartik\sortable\SortableInput;

/* @var $this yii\web\View */
/* @var $model backend\modules\admin\modules\rbac\models\AuthItem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="auth-item-form">
    <? $form = AddEditForm::begin() ?>
    <?= $form->field($model, 'name') ?>
    <?= $form->field($model, 'description') ?>
    <div class="row">
        <div class="col-6">
            <?= SortableInput::widget([
                'name' => 'kv-conn-1',
                'items' => [
                    1 => ['content' => 'Item # 1'],
                    2 => ['content' => 'Item # 2'],
                    3 => ['content' => 'Item # 3'],
                    4 => ['content' => 'Item # 4'],
                    5 => ['content' => 'Item # 5'],
                ],
                'hideInput' => false,
                'sortableOptions' => ['connected' => true],
                'options' => ['class' => 'form-control', 'readonly' => true]
            ]) ?>
        </div>
        <div class="col-6">
            <?= SortableInput::widget([
                'name' => 'kv-conn-2',
                'items' => [
                    10 => ['content' => 'Item # 10'],
                    20 => ['content' => 'Item # 20'],
                    30 => ['content' => 'Item # 30'],
                    40 => ['content' => 'Item # 40'],
                    50 => ['content' => 'Item # 50'],
                ],
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
