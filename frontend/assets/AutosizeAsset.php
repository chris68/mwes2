<?php
namespace frontend\assets;
use yii\web\AssetBundle;

/**
 * 
 */
class AutosizeAsset extends AssetBundle
{
    public $sourcePath = '@frontend/assets';
    public $js = [
        'autosize.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
