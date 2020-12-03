<?php

namespace rusbeldoor\yii2General\backend\assets;

/**
 * Class AssetBundle
 * @package rusbeldoor\yii2General\backend\assets
 */
class AssetBundle extends \yii\web\AssetBundle
{
    public $sourcePath = '@vendor/rusbeldoor/yii2-general/backend/web';

    public $css = [
        'css/yii2-general-backend.css',
    ];

    public $js = [
        'js/yii2-general-backend.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap4\BootstrapAsset',
        'rusbeldoor\yii2General\common\assets\AssetBundle',
    ];
}
