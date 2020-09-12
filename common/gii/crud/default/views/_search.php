<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$name = Inflector::camel2id(StringHelper::basename($generator->modelClass));

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->searchModelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="<?= $name ?>-search panel-search-form">
    <?= "<?php " ?>$form = ActiveForm::begin([
        'id' => 'standard-search-form',
        'action' => ['index'],
        'method' => 'post',
    ]); ?>
<?php foreach ($generator->getColumnNames() as $attribute) {
    if (in_array($attribute, ['id'])) { continue; }
    echo "    <?= " . $generator->generateActiveSearchField($attribute) . " ?>\n";
} ?>
    <div>
        <?= "<?= " ?>Html::submitButton('Применить', ['class' => 'btn btn-primary']) ?>
        <?= "<?= " ?>Html::a('<i class="fas fa-wind"></i> Сбросить', '/<?= $name ?>', ['class' => 'btn btn-outline-secondary']) ?>
    </div>
    <?= "<?php " ?>ActiveForm::end(); ?>
</div>
