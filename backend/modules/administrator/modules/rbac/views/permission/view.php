<?php

use rusbeldoor\yii2General\widgets\DetailView;
use rusbeldoor\yii2General\helpers\BaseUI;

/* @var $this yii\web\View */
/* @var $model backend\modules\administrator\modules\rbac\models\AuthItem */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Операции', 'url' => ['/administrator/rbac/permission']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$buttonsForViewPage = [];
if (!Yii::$app->controller->module->onlyMigrations) {
    $buttonsForViewPage[] = 'add';
    $buttonsForViewPage[] = 'delete';
}
?>
<div class="auth-item-view">
    <?= BaseUI::buttonsForViewPage($model, $buttonsForViewPage) ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'description',
        ],
    ]) ?>
</div>
