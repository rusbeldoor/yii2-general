<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var yii\web\View $this */
/* @var yii\gii\generators\crud\Generator $generator */

/* @var \yii\db\ActiveRecord $model */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use rusbeldoor\yii2General\widgets\AddOrEditForm;

/* @var yii\web\View $this */
/* @var <?= ltrim($generator->modelClass, '\\') ?> $model */
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">
    <?= "<? " ?>$form = AddOrEditForm::begin() ?>
<? foreach ($generator->getColumnNames() as $attribute) {
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
    <?= "<? " ?>AddOrEditForm::end() ?>
</div>
