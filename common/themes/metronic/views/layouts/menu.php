<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 20/9/2561
 * Time: 21:29
 */

use metronic\widgets\Menu;

?>
<div class="page-sidebar navbar-collapse collapse">
    <!-- BEGIN SIDEBAR MENU -->
    <?php
    echo Menu::widget([
        'key'=> Yii::$app->id,
        'activateParents' => true,
        'encodeLabels' => false,
        'options' => [
            'class' => 'page-sidebar-menu  page-header-fixed page-sidebar-menu-hover-submenu',
            'data-keep-expanded' => 'false',
            'data-slide-speed' => '200',
        ],
    ]);
    ?>
    <!-- END SIDEBAR MENU -->
</div>
