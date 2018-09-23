<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 21/9/2561
 * Time: 0:37
 */

use common\widgets\Alert;
use yii\helpers\Url;
use yii\helpers\Html;

$themeDirAsset = Yii::$app->assetManager->getPublishedUrl('@metronic/assets/vendor');
$this->registerCssFile($themeDirAsset . "/pages/css/login.min.css", [
    'depends' => [\yii\bootstrap\BootstrapAsset::className()],
]);
?>
<?php
$this->beginContent('@metronic/views/layouts/base.php', [
    'class' => 'login'
]);
?>
    <!-- BEGIN LOGO -->
    <div class="logo" style="margin-top: 10px;">
        <a href="<?= Url::base(true) ?>"><?= Html::img(Yii::getAlias('@web') . '/imgs/logo-hospital.png', [
                'class' => 'img-responsive center-block',
                'width' => '130px'
            ]) ?> </a>
    </div>
    <!-- END LOGO -->
    <!-- BEGIN CONTENT -->
    <div class="content" style="margin-top: 0px;">
        <!-- BEGIN CONTENT BODY -->
        <?= Alert::widget() ?>
        <?= $content ?>
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->
<?php $this->endContent(); ?>