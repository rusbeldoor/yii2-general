<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$name = Inflector::camel2id(StringHelper::basename($generator->modelClass));

echo "<?php\n";
?>

use yii\helpers\html;
use rusbeldoor\yii2General\widgets\SearchForm;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->searchModelClass, '\\') ?> */
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
