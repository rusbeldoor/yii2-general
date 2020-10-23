<?php
namespace rusbeldoor\yii2General\common\assets;

/**
 * Class AssetBundle
 * @package rusbeldoor\yii2General\common\assets
 */
class AssetBundle extends \yii\web\AssetBundle
{
    public $sourcePath = '@vendor/rusbeldoor/yii2-general/common/web';

    public $css = [
        'css/rusbeldoor-yii2-general-common.css',
    ];

    public $js = [
		'js/rusbeldoor-yii2-general-common.js',
		'js/reCaptcha.js',
	];

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap4\BootstrapAsset',
        'rusbeldoor\yii2General\common\assets\FontawesomeAssetBundle',
    ];
}
