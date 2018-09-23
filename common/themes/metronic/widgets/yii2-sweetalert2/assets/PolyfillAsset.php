<?php

namespace metronic\sweetalert2\assets;

use yii\web\AssetBundle;

class PolyfillAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@metronic/sweetalert2/assets';

    /**
     * @var array
     */
    public $js = [
        'src/js/promise-polyfill.js'
    ];
}
