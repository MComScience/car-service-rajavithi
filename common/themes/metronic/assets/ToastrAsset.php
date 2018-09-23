<?php
namespace metronic\assets;

use yii\web\AssetBundle;

class ToastrAsset extends AssetBundle 
{
    public $sourcePath = '@metronic/assets/toastr';

    public $css = [
        'build/toastr.min.css', 
    ];

    public $js = [
        'build/toastr.min.js', 
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}