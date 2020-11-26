<?php

use yii\helpers\html;
use rusbeldoor\yii2General\widgets\SearchForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\administrator\modules\rbac\models\AuthItemSearch */
?>

<div class="auth-item-search panelSearchFormContainer">
    <?php $form = SearchForm::begin() ?>
        <?= $form->field($model, 'alias')->searchTextInput() ?>
        <?= $form->field($model, 'description')->searchTextInput() ?>
        <?= $form->field($model, 'status') ?>
        <?= $form->field($model, 'max_duration')->searchNumberInputAppendSeconds(['min' => 0, 'max' => '86400']) ?>
        <?= $form->field($model, 'kill_process')->searchNumberYesNo() ?>
        <?= $form->field($model, 'restart')->searchNumberYesNo() ?>
        <?= $form->field($model, 'active')->searchNumberYesNo() ?>
        <?= $form->buttons() ?>
    <?php SearchForm::end() ?>
</div>
