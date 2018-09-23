<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 20/9/2561
 * Time: 20:34
 */

namespace metronic\assets;

use yii\web\AssetBundle;

class CrudAsset extends AssetBundle
{
    public $sourcePath = '@metronic/assets/ajaxcrud';

    public $css = [
        'css/ajaxcrud.css'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];

    public function init()
    {
        $this->js = YII_DEBUG ? [
            'js/ModalRemote.js',
            'js/ajaxcrud.js',
        ] : [
            'js/ModalRemote.min.js',
            'js/ajaxcrud.min.js',
        ];
        parent::init();
    }

}