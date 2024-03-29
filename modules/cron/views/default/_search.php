<?php
/**
 * @var yii\web\View $this
 * @var backend\modules\administrator\modules\rbac\models\AuthItemSearch $model
 */

use rusbeldoor\yii2General\models\Cron;
use rusbeldoor\yii2General\widgets\SearchForm;
?>

<div class="auth-item-search panelSearchFormContainer">
    <?php $form = SearchForm::begin() ?>
        <?= $form->field($model, 'id')->searchNumberInput() ?>
        <?= $form->field($model, 'alias')->searchTextInput() ?>
        <?= $form->field($model, 'description')->searchTextInput() ?>
        <?= $form->field($model, 'status')->searchSelect(Cron::$fieldsDescriptions['status']) ?>
        <?= $form->field($model, 'active')->searchNumberYesNo() ?>
        <?= $form->buttons() ?>
    <?php SearchForm::end() ?>
</div>
