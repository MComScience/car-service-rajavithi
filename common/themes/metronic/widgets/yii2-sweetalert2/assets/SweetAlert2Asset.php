<?php

namespace metronic\sweetalert2\assets;

use yii\web\AssetBundle;

/**
 * Class SweetAlert2Asset
 * @package homer\sweetalert2\assets
 */
class SweetAlert2Asset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@bower/sweetalert2/dist';

    /**
     * @var array
     */
    public $js = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        $min = YII_ENV_DEV ? '' : '.min';
        $this->js[] = 'sweetalert2.all' . $min . '.js';
    }

    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
        'metronic\sweetalert2\assets\PolyfillAsset'
    ];
}
