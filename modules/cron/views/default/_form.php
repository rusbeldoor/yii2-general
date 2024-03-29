<?php
/**
 * @var yii\web\View $this
 * @var backend\modules\administrator\modules\rbac\models\AuthItem $model
 */

use rusbeldoor\yii2General\widgets\AddOrEditForm;
?>

<div class="auth-item-form">
    <? $form = AddOrEditForm::begin() ?>
        <?= $form->errorSummary($model); ?>
        <?= $form->field($model, 'alias')->textInput(['maxlength' => 96]) ?>
        <?= $form->field($model, 'description') ?>
        <?= $form->field($model, 'max_duration')->numberInputAppendSeconds(['min' => 0])->hint('Не указано — не ограничена.'); ?>
        <?= $form->field($model, 'kill_process')->numberYesNo() ?>
        <?= $form->field($model, 'restart')->numberYesNo() ?>
        <?= $form->field($model, 'active')->numberYesNo() ?>
        <?= $form->buttons($model) ?>
    <? AddOrEditForm::end() ?>
</div>
