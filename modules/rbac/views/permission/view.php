<?php
/**
 * @var yii\web\View $this
 * @var backend\modules\administrator\modules\rbac\models\AuthItem $model
 */

use rusbeldoor\yii2General\widgets\DetailView;
use rusbeldoor\yii2General\helpers\BaseUI;

$this->title = $model->name;
$this->context->addBreadcrumb('Операции', ['/administrator/rbac/permission']);
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
        ],
    ]) ?>
</div>
