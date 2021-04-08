<?php
/**
 * This is the template for generating a controller class within a module.
 */

/* @var yii\web\View $this */
/* @var yii\gii\generators\module\Generator $generator */

$baseClass = explode('\\', $generator->moduleClass);
switch ($baseClass[0]) {
    case 'backend': $baseClass = '\backend\components\Controller'; break;
    case 'frontend': $baseClass = '\frontend\components\Controller'; break;
    default: $baseClass = '\rusbeldoor\yii2General\components\WebController'; break;
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
