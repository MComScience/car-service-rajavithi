<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 20/9/2561
 * Time: 21:21
 */

use common\widgets\Alert;
use metronic\widgets\Breadcrumbs;
?>
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <div class="page-sidebar-wrapper">
        <!-- END SIDEBAR -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <?= $this->render('menu'); ?>
        <!-- END SIDEBAR -->
    </div>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->
            <div class="page-bar">
                <?= Breadcrumbs::widget([
                    'homeLink' => [
                        'label' => '<i class="icon-home"></i> ' . \Yii::t('yii', 'Home'),
                        'url' => Yii::$app->homeUrl,
                        'encode' => false
                    ],
                    'activeItemTemplate' => "<li class=\"active\"><span>{link}</span></li>\n",
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    'tag' => 'ul',
                    'encodeLabels' => false,
                    'options' => ['class' => 'page-breadcrumb'],
                ]) ?>
            </div>
            <!-- END PAGE HEADER-->
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->
</div>
