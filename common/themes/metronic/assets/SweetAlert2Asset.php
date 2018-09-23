<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 20/9/2561
 * Time: 23:31
 */
namespace metronic\assets;

use yii\web\AssetBundle;

class SweetAlert2Asset extends AssetBundle
{
    public $sourcePath = '@bower/sweetalert2';

    public $css = [
        'dist/sweetalert2.min.css',
    ];

    public $js = [
        'dist/sweetalert2.all.min.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}