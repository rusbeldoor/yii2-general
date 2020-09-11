<?php

namespace rusbeldoor\yii2General\backend\assets;

/**
 * Class AssetBundle
 * @package rusbeldoor\yii2General\backend\assets
 */
class AssetBundle extends \yii\web\AssetBundle
{
    public $sourcePath = '@vendor/rusbeldoor/yii2-general/backend/web';
    public $css = ['css/main.css'];
    public $js = ['js/main.js'];
}
