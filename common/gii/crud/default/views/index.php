<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use yii\helpers\Html;
use <?= $generator->indexWidgetType === 'grid' ? "yii\\grid\\GridView" : "yii\\widgets\\ListView" ?>;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index">
    <div class="panel-buttons-group clearfix">
        <?= "<?= " ?>Html::button('<i class="fas fa-filter"></i> Фильтр', ['class' => 'btn btn-light panel-button-search-form']) ?>
        <div class="float-right">
            <?= "<?= " ?>Html::a('<i class="fas fa-plus"></i> Добавить', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?= "<?php " ?>Pjax::begin(); ?>
<?php if(!empty($generator->searchModelClass)): ?>
<?= "    <?= " ?>$this->render('_search', ['model' => $searchModel]); ?>
<?php endif; ?>

<?php if ($generator->indexWidgetType === 'grid'): ?>
    <?= "<?= " ?>GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-striped table-hover'],
        'columns' => [
<?php
foreach ($generator->getColumnNames() as $name) {
    echo "            ";
    switch ($name) {
        case 'id': echo "['class' => 'rusbeldoor\yii2-general\common\widgets\grid\IdColumn']"; break;
        case 'archive': echo "['class' => 'rusbeldoor\yii2-general\common\widgets\grid\ArchiveColumn']"; break;
        default: echo "'" . $name . "'";
    }
    echo ",\n";
}
?>
            ['class' => 'rusbeldoor\yii2-general\common\widgets\grid\ActionColumn'],
        ],
    ]); ?>
<?php else: ?>
    <?= "<?= " ?>ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model-><?= $nameAttribute ?>), ['view', <?= $urlParams ?>]);
        },
    ]) ?>
<?php endif; ?>

    <?= "<?php " ?>Pjax::end(); ?>
</div>
