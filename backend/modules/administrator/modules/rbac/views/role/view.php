<?php

use kartik\sortinput\SortableInput;
use rusbeldoor\yii2General\widgets\DetailView;
use rusbeldoor\yii2General\helpers\BaseUI;

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
            'name',
            'description',
            'roles' => [
                'value' => function ($rolesOfThisRole) {
                    return SortableInput::widget([
                        'items' => $rolesOfThisRole,
                        'sortableOptions' => [
                            'itemOptions' => ['class' => 'alert alert-warning'],
                        ],
                        'options' => ['class' => 'form-control', 'readonly' => true]
                    ]);
                }
            ],
            'permissions' => [
                'value' => function ($permissionsOfThisRole) {
                    return SortableInput::widget([
                        'items' => $permissionsOfThisRole,
                        'sortableOptions' => [
                            'itemOptions' => ['class' => 'alert alert-warning'],
                        ],
                        'options' => ['class' => 'form-control', 'readonly' => true]
                    ]);
                }
            ],
        ],
    ]) ?>
</div>

<div class="form-group row">

</div>
<div class="form-group row">
    <label class="col-form-label col-md-2">Операции</label>
    <div class="col-md-5">
        <?= SortableInput::widget([
            'name' => 'permissions-names',
            'items' => $permissionsNotOfThisRole,
            'sortableOptions' => ['connected' => 'permissions'],
            'options' => ['class' => 'form-control', 'readonly' => true]
        ]) ?>
    </div>
    <div class="col-md-5">
        <?= SortableInput::widget([
            'name' => 'child-permissions-names',
            'items' => $permissionsOfThisRole,
            'sortableOptions' => [
                'itemOptions' => ['class' => 'alert alert-warning'],
                'connected' => 'permissions',
            ],
            'options' => ['class' => 'form-control', 'readonly' => true]
        ]) ?>
    </div>
</div>
