<?php
namespace rusbeldoor\yii2General\common\assets\bootswatch;

/**
 * Class AssetBundle
 * @package rusbeldoor\yii2General\common\assets\bootswatch
 */
class FlatlyAssetBundle extends \yii\web\AssetBundle
{
    public $sourcePath = '@vendor/thomaspark/bootswatch/dist/flatly';
    public $css = ['bootstrap.min.css'];
    public $js = [];
}
