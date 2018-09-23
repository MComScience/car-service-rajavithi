<?php
namespace metronic\widgets\datatables;

use yii\web\AssetBundle;

class DataTablesBootstrapAsset extends AssetBundle
{
    public $sourcePath = '@bower/datatables.net-bs';

    public $css = [
        'css/dataTables.bootstrap.min.css',
    ];

    public $js = [
        'js/dataTables.bootstrap.min.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'metronic\widgets\datatables\DataTablesAsset',
    ];
}