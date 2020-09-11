<?php

namespace rusbeldoor\yii2General\common\assets;

/**
 * Class AssetBundle
 * @package rusbeldoor\yii2General\common\assets
 */
class AssetBundle extends \yii\web\AssetBundle
{
    public $sourcePath = '@vendor/quick-service/yii2/common/web';
    public $css = ['css/main.css'];
    public $js = [
		'js/main.js',
		'js/reCaptcha.js',
	];
}
