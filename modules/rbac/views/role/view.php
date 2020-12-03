<?php

use rusbeldoor\yii2General\widgets\DetailView;
use rusbeldoor\yii2General\helpers\BaseUI;
use kartik\sortinput\SortableInput;

/* @var $this yii\web\View */
/* @var $model backend\modules\administrator\modules\rbac\models\AuthItem */
/* @var $rolesOfThisRole array */
/* @var $permissionsOfThisRole array */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Роли', 'url' => ['/administrator/rbac/role']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$buttonsForViewPage = ['add', 'delete'];
if (Yii::$app->controller->module->onlyMigrations) {
    unset($buttonsForViewPage[array_search('add', $buttonsForViewPage)]);
    unset($buttonsForViewPage[array_search('delete', $buttonsForViewPage)]);
}
?>
<div class="auth-item-view">
    <?= BaseUI::buttonsForViewPage($model, $buttonsForViewPage) ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id:id',
            'name',
            'description',
            [
                'label' => 'Роли',
                'format' => 'html',
                'value' => ((count($rolesOfThisRole)) ? SortableInput::widget([
                    'name' => 'child-roles-names',
                    'items' => $rolesOfThisRole,
                    'sortableOptions' => ['itemOptions' => ['class' => 'alert alert-success']],
                    'options' => ['class' => 'form-control', 'readonly' => true]
                ]) : '-'),
            ],
            [
                'label' => 'Операции',
                'format' => 'html',
                'value' => ((count($permissionsOfThisRole)) ? SortableInput::widget([
                    'name' => 'child-permissions-names',
                    'items' => $permissionsOfThisRole,
                    'sortableOptions' => ['itemOptions' => ['class' => 'alert alert-success']],
                    'options' => ['class' => 'form-control', 'readonly' => true]
                ]) : '-'),
            ],
        ],
    ]) ?>
</div>
