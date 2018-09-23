<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 20/9/2561
 * Time: 21:18
 */
$themeDirAsset = Yii::$app->assetManager->getPublishedUrl('@metronic/assets/vendor');
?>
<?php
$this->beginContent('@metronic/views/layouts/base.php', [
    'class' => \Yii::$app->keyStorage->get('theme.body.class', 'page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-md')
]);
?>
<!-- BEGIN HEADER -->
<?= $this->render('header', ['themeDirAsset' => $themeDirAsset]); ?>
<!-- END HEADER -->
<!-- BEGIN HEADER & CONTENT DIVIDER -->
<div class="clearfix"></div>
<!-- END HEADER & CONTENT DIVIDER -->
<!-- BEGIN CONTAINER -->
<?= $this->render('content', ['content' => $content, 'themeDirAsset' => $themeDirAsset]); ?>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<?= $this->render('footer', ['themeDirAsset' => $themeDirAsset]); ?>
<!-- END FOOTER -->
<?php $this->endContent(); ?>
