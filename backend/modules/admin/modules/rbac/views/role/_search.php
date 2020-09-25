<?php

use yii\helpers\html;
use rusbeldoor\yii2General\widgets\SearchForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\admin\modules\rbac\models\AuthItemSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="auth-item-search panelSearchFormContainer">
    <?php $form = SearchForm::begin() ?>
        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'type') ?>
        <?= $form->field($model, 'description') ?>
        <?= $form->field($model, 'rule_name') ?>
        <?= $form->field($model, 'data') ?>
        <?= $form->field($model, 'created_at') ?>
        <?= $form->field($model, 'updated_at') ?>
        <?= $form->buttons() ?>
    <?php SearchForm::end() ?>
</div>
