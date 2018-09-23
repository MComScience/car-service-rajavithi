<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 20/9/2561
 * Time: 21:07
 */
namespace metronic\assets;

use yii\web\AssetBundle;

class FontAwesomeAsset extends AssetBundle
{
    public $sourcePath = '@metronic/assets/font-awesome';

    public $css = [
        'css/font-awesome.min.css',
    ];

    public $publishOptions = [
        'only' => [
            'fonts/*',
            'css/*',
        ],
    ];
}