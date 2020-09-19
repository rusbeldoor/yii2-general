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
        'css/rusbeldoor-yii2-general-backend.css',
    ];

    public $js = [
        'js/rusbeldoor-yii2-general-backend.js',
    ];

    public $depends = [
        'rusbeldoor\yii2General\common\assets\AssetBundle',
    ];
}
