<?php

use rusbeldoor\yii2General\widgets\DetailView;
use rusbeldoor\yii2General\helpers\BaseUI;

/* @var yii\web\View $this */
/* @var backend\modules\administrator\modules\rbac\models\AuthItem $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Операции', 'url' => ['/administrator/rbac/permission']];
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
        ],
    ]) ?>
</div>
