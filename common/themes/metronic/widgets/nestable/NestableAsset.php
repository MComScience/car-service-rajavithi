<?php

namespace metronic\widgets\nestable;

use yii\web\AssetBundle;

class NestableAsset extends AssetBundle
{
    public $sourcePath = '@metronic/widgets/nestable/assets';

    public $css = [
        'css/nestable.css'
    ];

    public $js = [
        'js/jquery.nestable.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}