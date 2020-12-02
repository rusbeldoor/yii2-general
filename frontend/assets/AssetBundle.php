<?php

namespace rusbeldoor\yii2General\frontend\assets;

/**
 * Class AssetBundle
 * @package rusbeldoor\yii2General\frontend\assets
 */
class AssetBundle extends \yii\web\AssetBundle
{
    public $sourcePath = '@vendor/rusbeldoor/yii2-general/frontend/web';

    public $css = [
        'css/rusbeldoor-yii2-general-frontend.css',
    ];

    public $js = [
        'js/rusbeldoor-yii2-general-frontend.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap4\BootstrapAsset',
        'rusbeldoor\yii2General\common\assets\AssetBundle',
    ];
}
