<?php

/* @var yii\web\View $this */
/* @var backend\modules\administrator\modules\rbac\models\AuthItemSearch $model */

use yii\helpers\html;
use rusbeldoor\yii2General\models\Platform;
use rusbeldoor\yii2General\widgets\SearchForm;
?>

<div class="auth-item-search panelSearchFormContainer">
    <?php $form = SearchForm::begin() ?>
        <?= $form->field($model, 'id')->searchNumberInput() ?>
        <?= $form->field($model, 'alias')->searchTextInput() ?>
        <?= $form->field($model, 'name')->searchTextInput() ?>
        <?= $form->buttons() ?>
    <?php SearchForm::end() ?>
</div>
