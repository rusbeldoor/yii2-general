<?php

namespace rusbeldoor\yii2-general\backend\assets;

/**
 * Class AssetBundle
 * @package rusbeldoor\yii2-general\backend\assets
 */
class AssetBundle extends \yii\web\AssetBundle
{
    public $sourcePath = '@vendor/quick-service/yii2/backend/web';
    public $css = ['css/main.css'];
    public $js = ['js/main.js'];
}
