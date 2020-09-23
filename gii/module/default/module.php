<?php
/**
 * This is the template for generating a module class file.
 */

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\module\Generator */

$className = $generator->moduleClass;
$pos = strrpos($className, '\\');
$ns = ltrim(substr($className, 0, $pos), '\\');
$className = substr($className, $pos + 1);

$baseClass = explode('\\', $generator->controllerClass);
switch ($baseClass[0]) {
    case 'backend': $baseClass = 'backend\components\Module'; break;
    case 'frontend': $baseClass = 'frontend\components\Module'; break;
    default: $baseClass = 'components\Module'; break;
}

echo "<?php\n";
?>

namespace <?= $ns ?>;

/**
 * <?= $generator->moduleID ?> module definition class
 */
class <?= $className ?> extends <?= $baseClass . "\n" ?>
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = '<?= $generator->getControllerNamespace() ?>';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
