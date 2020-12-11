<?php

/* @var $this yii\web\View */
/* @var $model backend\modules\administrator\modules\rbac\models\AuthItem */
/* @var $cronLogDataProvider ActiveDataProvider */

use rusbeldoor\yii2General\widgets\DetailView;
use rusbeldoor\yii2General\widgets\grid\GridView;
use rusbeldoor\yii2General\helpers\BaseUI;
use kartik\tabs\TabsX;

$this->title = $model->alias;
$this->params['breadcrumbs'][] = ['label' => 'Кроны', 'url' => ['/administrator/cron']];
$this->params['breadcrumbs'][] = $this->title;
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
                            'description',
                            'status:status',
                            'max_duration:countMinuteSecond',
                            'kill_process:yesNo',
                            'restart:yesNo',
                            'active:yesNo',
                        ],
                    ]),
                'active' => true,
            ],
            [
                'label' => '<i class="fas fa-history"></i> История запусков',
                'content' => GridView::widget([
                    'dataProvider' => $cronLogDataProvider,
                    'columns' => [
                        'duration:countMinuteSecond',
                        'datetime_start:datetimeHourMinuteDayMonthYear',
                        'datetime_complete:datetimeHourMinuteDayMonthYear',
                        'pid',
                    ],
                ]),
            ],
        ],
        'position' => TabsX::POS_ABOVE,
        'encodeLabels' => false,
    ]) ?>
</div>
