<?php
namespace metronic\widgets\datatables;

use yii\web\AssetBundle;

class DataTablesAsset extends AssetBundle
{
    public $sourcePath = '@metronic/widgets/datatables/assets';

    public $css = [
        'media/css/dataTables.bootstrap.min.css',
        'extensions/Responsive/css/responsive.bootstrap.min.css',
        'extensions/Buttons/css/buttons.dataTables.min.css',
    ];

    public $js = [
        'media/js/jquery.dataTables.min.js',
        'media/js/dataTables.bootstrap.min.js',
        'extensions/Responsive/js/dataTables.responsive.min.js',
        'extensions/Buttons/js/dataTables.buttons.min.js',
        'extensions/Buttons/js/buttons.flash.min.js',
        'extensions/Buttons/js/jszip.min.js',
        'extensions/Buttons/js/pdfmake.min.js',
        'extensions/Buttons/js/vfs_fonts.js',
        'extensions/Buttons/js/buttons.html5.min.js',
        'extensions/Buttons/js/buttons.print.min.js',
        'extensions/Buttons/js/buttons.colVis.min.js',
        'media/js/datatable.func.js',
        'media/js/dataTables.api.js',
        'media/js/plug-ins.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'metronic\assets\SweetAlert2Asset',
        'kartik\select2\Select2Asset',
        'kartik\select2\ThemeBootstrapAsset'
    ];
}
