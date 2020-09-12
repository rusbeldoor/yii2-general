<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = $model-><?= $generator->getNameAttribute() ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-view">
    <div class="panel-buttons-group clearfix">
        <div class="float-right">
            <?= "<?= " ?>Html::a(
                '<i class="fas fa-pencil-alt"></i> Изменить',
                ['update', <?= $urlParams ?>],
                ['class' => 'btn btn-success']
            ) ?>&nbsp;&nbsp;<?= "<?= " ?>Html::a(
                '<i class="far fa-trash-alt"></i> Удалить',
                ['delete', <?= $urlParams ?>],
                [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => <?= $generator->generateString('Вы уверены, что хотите удалить этот элемент?') ?>,
                        'method' => 'post',
                    ],
                ]
            ) ?>
        </div>
    </div>
    <?= "<?= " ?>DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'table table-striped table-hover'],
        'attributes' => [
<?php
foreach ($generator->getColumnNames() as $name) {
    echo "            '" . $name . "',\n";
}
?>
        ],
    ]) ?>
</div>
