<?php

use yii\helpers\html;
use rusbeldoor\yii2General\widgets\SearchForm;

/* @var yii\web\View $this */
/* @var backend\modules\administrator\modules\rbac\models\AuthItemSearch $model */
?>

<div class="auth-item-search panelSearchFormContainer">
    <?php $form = SearchForm::begin() ?>
        <?= $form->field($model, 'id') ?>
        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'description') ?>
        <?= $form->buttons() ?>
    <?php SearchForm::end() ?>
</div>
