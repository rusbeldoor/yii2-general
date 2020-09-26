<?php

use rusbeldoor\yii2General\widgets\DetailView;
use rusbeldoor\yii2General\helpers\BaseUI;

/* @var $this yii\web\View */
/* @var $model backend\modules\admin\modules\rbac\models\AuthItem */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Роли', 'url' => ['/admin/rbac/role']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="auth-item-view">
    <?= BaseUI::buttonsForViewPage($model, ['add', 'delete']) ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'description',
        ],
    ]) ?>
</div>
