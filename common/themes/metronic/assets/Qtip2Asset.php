<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 22/9/2561
 * Time: 14:56
 */
namespace metronic\assets;

use yii\web\AssetBundle;

class Qtip2Asset extends AssetBundle
{
    public $sourcePath = '@metronic/assets/qtip2';

    public $css = [
        'jquery.qtip.min.css',
    ];

    public $js = [
        'jquery.qtip.min.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}