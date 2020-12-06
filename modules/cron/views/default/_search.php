<?php

use yii\helpers\html;
use rusbeldoor\yii2General\models\Cron;
use rusbeldoor\yii2General\widgets\SearchForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\administrator\modules\rbac\models\AuthItemSearch */
?>

<div class="auth-item-search panelSearchFormContainer">
    <?php $form = SearchForm::begin() ?>
        <?= $form->field($model, 'id')->searchTextInput() ?>
        <?= $form->field($model, 'alias')->searchTextInput() ?>
        <?= $form->field($model, 'description')->searchTextInput() ?>
        <?= $form->field($model, 'status')->searchSelect(Cron::$fieldsDescriptions['status']) ?>
        <?= $form->field($model, 'active')->searchNumberYesNo() ?>
        <?= $form->buttons() ?>
    <?php SearchForm::end() ?>
</div>
