<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 22/9/2561
 * Time: 16:16
 */
namespace frontend\assets;

use yii\web\AssetBundle;

class SocketIOAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'vendor/socket.io-client/socket.io.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
    ];
}