<?php
/**
 * This is the template for generating a controller class within a module.
 */

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\module\Generator */

$baseClass = explode('\\', $generator->moduleClass);
switch ($baseClass[0]) {
    case 'backend': $baseClass = 'backend\components\Controller'; break;
    case 'console': $baseClass = 'console\components\Controller'; break;
    case 'frontend': $baseClass = 'frontend\components\Controller'; break;
    default: $baseClass = '\yii\web\Controller'; break;
}

echo "<?php\n";
?>

namespace <?= $generator->getControllerNamespace() ?>;

/**
 * Default controller for the `<?= $generator->moduleID ?>` module
 */
class DefaultController extends <?= $baseClass . "\n" ?>
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
