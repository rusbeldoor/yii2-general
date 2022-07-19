<?php
/**
 * @var yii\web\View $this
 * @var backend\modules\administrator\modules\rbac\models\AuthItem $model
 * @var array $rolesOfThisRole
 * @var array $permissionsOfThisRole
 */

use rusbeldoor\yii2General\widgets\DetailView;
use rusbeldoor\yii2General\helpers\BaseUI;
use kartik\sortinput\SortableInput;

$this->title = $model->name;
$this->context->addBreadcrumb('Роли', ['/administrator/rbac/role']);
$this->context->addBreadcrumb($model->name);
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
