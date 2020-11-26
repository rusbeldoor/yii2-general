<?php

use yii\helpers\html;
use rusbeldoor\yii2General\widgets\SearchForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\administrator\modules\rbac\models\AuthItemSearch */
?>

<div class="auth-item-search panelSearchFormContainer">
    <?php $form = SearchForm::begin() ?>
        <?= $form->field($model, 'alias') ?>
        <?= $form->field($model, 'description') ?>
        <?= $form->field($model, 'status') ?>
        <?= $form->field($model, 'max_duration') ?>
        <?= $form->field($model, 'kill_process')->searchNumberYesNo() ?>
        <?= $form->field($model, 'restart')->searchNumberYesNo() ?>
        <?= $form->field($model, 'active')->searchNumberYesNo() ?>
        <?= $form->buttons() ?>
    <?php SearchForm::end() ?>
</div>
