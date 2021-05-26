<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var yii\web\View $this */
/* @var yii\gii\generators\crud\Generator $generator */

$name = Inflector::camel2id(StringHelper::basename($generator->modelClass));

echo "<?php\n";
?>

use yii\helpers\html;
use rusbeldoor\yii2General\widgets\SearchForm;

/* @var yii\web\View $this */
/* @var <?= ltrim($generator->searchModelClass, '\\') ?> $model */
?>

<div class="<?= $name ?>-search panelSearchFormContainer">
    <?= "<? " ?>$form = SearchForm::begin() ?>
<?php foreach ($generator->getColumnNames() as $attribute) {
    // Если аттрибут не разрешен к выводу
    if (in_array($attribute, ['id'])) { continue; }
    echo "        ";
    echo "<?= " . $generator->generateActiveSearchField($attribute) . " ?>";
    echo "\n";
} ?>
        <?= "<?= " ?>$form->buttons() ?>
    <?= "<? " ?>SearchForm::end() ?>
</div>
