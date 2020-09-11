<?php

namespace rusbeldoor\yii2General\backend\assets;

/**
 * Class AssetBundle
 * @package rusbeldoor\yii2General\backend\assets
 */
class AssetBundle extends \yii\web\AssetBundle
{
    public $sourcePath = '@vendor/quick-service/yii2/backend/web';
    public $css = ['css/main.css'];
    public $js = ['js/main.js'];
}
