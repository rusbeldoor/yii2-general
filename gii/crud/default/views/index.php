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
use yii\widgets\Pjax;
use <?= $generator->indexWidgetType === 'grid' ? "rusbeldoor\yii2General\grid\GridView" : "yii\\widgets\\ListView" ?>;

use rusbeldoor\yii2General\common\helpers\BaseUI;

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index">
    <?= "<?= " ?>BaseUI::buttonsForIndexPage(['filter', 'add', 'delete']) ?>

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
        case 'id': echo "'id:id'"; break;
        case 'archive': echo "['class' => 'rusbeldoor\yii2General\grid\ArchiveColumn']"; break;
        default: echo "'" . $name . "'";
    }
    echo ",\n";
}
?>
            ['class' => 'rusbeldoor\yii2General\grid\ActionColumn'],
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
