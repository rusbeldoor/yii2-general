<?php

namespace rusbeldoor\yii2General\frontend\assets;

/**
 * Class AssetBundle
 * @package rusbeldoor\yii2General\frontend\assets
 */
class AssetBundle extends \yii\web\AssetBundle
{
    public $sourcePath = '@vendor/rusbeldoor/yii2General/frontend/web';
    public $css = ['css/main.css'];
    public $js = ['js/main.js'];
}
