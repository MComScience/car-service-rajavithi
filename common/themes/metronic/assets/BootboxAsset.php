<?php
namespace metronic\assets;

use yii\web\AssetBundle;

class BootboxAsset extends AssetBundle
{
    public $sourcePath = '@metronic/assets/bootbox';

    public $js = [
        'bootbox.min.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}