<?php

namespace rusbeldoor\yii2General\common\assets;

/**
 * Class AssetBundle
 * @package rusbeldoor\yii2General\common\assets
 */
class AssetBundle extends \yii\web\AssetBundle
{
    public $sourcePath = '@vendor/rusbeldoor/yii2-general/common/web';
    public $css = ['css/rusbeldoor-yii2-general-backend.css'];
    public $js = [
		'js/rusbeldoor-yii2-general-backend.js',
		'js/reCaptcha.js',
	];
    public $depends = [
        'rusbeldoor\yii2General\common\assets\FontawesomeAssetBundle',
    ];
}
