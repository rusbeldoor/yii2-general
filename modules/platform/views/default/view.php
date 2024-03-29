<?php
/**
 * @var yii\web\View $this
 * @var backend\modules\administrator\modules\rbac\models\AuthItem $model
 */

use rusbeldoor\yii2General\widgets\DetailView;
use rusbeldoor\yii2General\helpers\BaseUI;
use kartik\tabs\TabsX;

$this->title = $model->alias;
$this->context->addBreadcrumb('Платформы', ['/administrator/platform']);
$this->context->addBreadcrumb($model->alias);
\yii\web\YiiAsset::register($this);

$buttonsForViewPage = ['add', 'delete'];
if (Yii::$app->controller->module->onlyMigrations) {
    unset($buttonsForViewPage[array_search('add', $buttonsForViewPage)]);
    unset($buttonsForViewPage[array_search('delete', $buttonsForViewPage)]);
}
?>

<div class="auth-item-view">
    <?= TabsX::widget([
        'items' => [
            [
                'label' => '<i class="fas fa-bars"></i> Основное',
                'content' =>
                    BaseUI::buttonsForViewPage($model, $buttonsForViewPage)
                    . DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id:id',
                            'alias',
                            'name',
                        ],
                    ]),
                'active' => true,
            ],
        ],
        'position' => TabsX::POS_ABOVE,
        'enableStickyTabs' => true,
        'encodeLabels' => false,
    ]) ?>
</div>
