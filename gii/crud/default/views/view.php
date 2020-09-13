<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\helpers\Html;
use rusbeldoor\yii2General\widgets\grid\DetailView;
use rusbeldoor\yii2General\common\helpers\BaseUI;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = $model-><?= $generator->getNameAttribute() ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['/<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-view">
    <?= "<?= " ?>BaseUI::buttonsForViewPage($model, ['add', 'delete']) ?>

    <?= "<?= " ?>DetailView::widget([
        'model' => $model,
        'attributes' => [
<?php
foreach ($generator->getColumnNames() as $name) {
    echo "            ";
    switch ($name) {
        case 'id': echo "'id:id'"; break;
        case 'archive': echo "'archive:yesNo'"; break;
        default: echo "'" . $name . "'";
    }
    echo ",\n";
}
?>
        ],
    ]) ?>
</div>
