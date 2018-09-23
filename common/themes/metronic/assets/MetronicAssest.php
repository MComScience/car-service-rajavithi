<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 20/9/2561
 * Time: 20:58
 */

namespace metronic\assets;

use yii\web\AssetBundle;

class MetronicAssest extends AssetBundle
{
    public $sourcePath = '@metronic/assets/vendor';

    public $css = [
        'http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all',
        'global/plugins/simple-line-icons/simple-line-icons.min.css',
        'global/css/components-md.min.css',
        'global/css/plugins-md.min.css',
        'layouts/layout2/css/layout.min.css',
        'layouts/layout2/css/themes/blue.min.css',
        'layouts/layout2/css/custom.min.css'
    ];

    public $js = [
        'global/plugins/js.cookie.min.js',
        'global/plugins/jquery-slimscroll/jquery.slimscroll.min.js',
        'global/plugins/jquery.blockui.min.js',
        'global/scripts/app.min.js',
        'layouts/layout2/scripts/layout.min.js',
        'layouts/layout2/scripts/demo.min.js',
        'layouts/global/scripts/quick-sidebar.min.js',
        'layouts/global/scripts/quick-nav.min.js'
    ];

    public $depends = [
        'metronic\assets\FontAwesomeAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}