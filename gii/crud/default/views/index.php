<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use rusbeldoor\yii2General\widgets\grid\GridView;
use rusbeldoor\yii2General\helpers\BaseUI;

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index">
    <?= "<?= " ?>BaseUI::buttonsForIndexPage(['filter', 'add', 'delete']) ?>

<?php if(!empty($generator->searchModelClass)): ?>
<?= "    <?= " ?>$this->render('_search', ['model' => $searchModel]); ?>
<?php endif; ?>

    <?= "<?= " ?>GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-striped table-hover'],
        'columns' => [
            ['class' => 'rusbeldoor\yii2General\widgets\grid\BulkActionColumn'],
<?php
foreach ($generator->getColumnNames() as $name) {
    echo "            ";
    switch ($name) {
        case 'id': echo "'id:id'"; break;
        case 'archive': echo "['class' => 'rusbeldoor\yii2General\widgets\grid\ArchiveColumn']"; break;
        default: echo "'" . $name . "'";
    }
    echo ",\n";
}
?>
            ['class' => 'rusbeldoor\yii2General\widgets\grid\ActionColumn'],
        ],
    ]); ?>
</div>
