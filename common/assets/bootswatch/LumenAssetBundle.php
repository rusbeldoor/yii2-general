<?php

namespace rusbeldoor\yii2General\common\assets\bootswatch;

/**
 * Class AssetBundle
 * @package rusbeldoor\yii2General\common\assets\bootswatch
 */
class LumenAssetBundle extends \yii\web\AssetBundle
{
    public $sourcePath = '@vendor/thomaspark/bootswatch/dist/lumen';
    public $css = ['bootstrap.min.css'];
    public $js = [];
}
