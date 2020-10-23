<?php
namespace rusbeldoor\yii2General\common\assets;

/**
 * Class AssetBundle
 * @package rusbeldoor\yii2General\common\assets
 */
class FontawesomeAssetBundle extends \yii\web\AssetBundle
{
    public $sourcePath = '@vendor/fortawesome/font-awesome';

    public $css = [
        'css/all.min.css',
    ];

    public $js = [
    ];
}
