<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">
    <?= "<?php " ?>$form = ActiveForm::begin() ?>
<?php foreach ($generator->getColumnNames() as $attribute) {
    if (
        // Если аттрибут не разрешен к массовому присваиванию
        !in_array($attribute, $safeAttributes)
        // Если аттрибут не разрешен к выводу
        || in_array($attribute, ['archive'])
    ) { continue; }
    echo "        ";
    echo "<?= " . $generator->generateActiveField($attribute) . " ?>";
    echo "\n";
} ?>
        <?= "<?= " ?>$form->buttons($model) ?>
    <?= "<?php " ?>ActiveForm::end() ?>
</div>
