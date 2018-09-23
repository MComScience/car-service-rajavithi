<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 20/9/2561
 * Time: 21:21
 */

use yii\bootstrap\Dropdown;
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\icons\Icon;

$ctr = Yii::$app->controller->id;
$action  = Yii::$app->controller->action->id;

$identity = Yii::$app->user->identity;
?>
<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner ">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="<?= Url::base(true); ?>" class="logo-default" style="text-decoration: none;text-transform: uppercase;margin: 19px 20px 0px;font-size: 18px;color: #fff;">
                rajavithi
            </a>
            <div class="menu-toggler sidebar-toggler">
                <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
            </div>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <?= Html::a('', 'javascript:;', [
            'class' => 'menu-toggler responsive-toggler',
            'data-toggle' => 'collapse',
            'data-target' => '.navbar-collapse'
        ]); ?>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN PAGE ACTIONS -->
        <!-- DOC: Remove "hide" class to enable the page header actions -->
        <div class="page-actions">
            <span class="font-blue-hoki bold uppercase" style="font-size: 18px;">โปรแกรมบริหารรถยนต์โรงพยาบาลราชวิถี</span>
        </div>
        <!-- END PAGE ACTIONS -->
        <!-- BEGIN PAGE TOP -->
        <div class="page-top">
            <!-- BEGIN TOP NAVIGATION MENU -->
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <!-- BEGIN NOTIFICATION DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class below "dropdown-extended" to change the dropdown styte -->
                    <!-- DOC: Apply "dropdown-hoverable" class after below "dropdown" and remove data-toggle="dropdown" data-hover="dropdown" data-close-others="true" attributes to enable hover dropdown mode -->
                    <!-- DOC: Remove "dropdown-hoverable" and add data-toggle="dropdown" data-hover="dropdown" data-close-others="true" attributes to the below A element with dropdown-toggle class -->
                    <?php if (!Yii::$app->user->isGuest) : ?>
                        <!-- BEGIN USER LOGIN DROPDOWN -->
                        <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                        <li class="dropdown dropdown-user">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                               data-close-others="true">
                                <img alt="" class="img-circle"
                                     src="<?= $identity->profile->getAvatar(); ?>"/>
                                <span class="username username-hide-on-mobile"> <?= $identity->profile->name; ?> </span>
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <?php
                            echo Dropdown::widget([
                                'items' => [
                                    [
                                        'label' => '<i class="icon-user"></i> ข้อมูลส่วนตัว',
                                        'url' => '/user/settings/profile'
                                    ],
                                    [
                                        'label' => '<i class="icon-users"></i> จัดการผู้ใช้งาน',
                                        'url' => '/user/admin/index',
                                        'visible' => Yii::$app->user->can('Admin')
                                    ],
                                    [
                                        'label' => '<i class="icon-users"></i> สิทธิ์การใช้งาน',
                                        'url' => '/rbac',
                                        'visible' => Yii::$app->user->can('Admin')
                                    ],
                                    '<li class="divider"></li>',
                                    [
                                        'label' => '<i class="icon-lock"></i> Lock Screen',
                                        'url' => 'javascript:;'
                                    ],
                                    [
                                        'label' => '<i class="icon-login"></i> ออกจากระบบ',
                                        'url' => '/auth/logout',
                                        'linkOptions' => ['data-method' => 'post']
                                    ],
                                ],
                                'options' => [
                                    'class' => 'dropdown-menu dropdown-menu-default',
                                ],
                                'encodeLabels' => false,
                            ]);
                            ?>
                        </li>
                    <?php else: ?>
                        <!-- END USER LOGIN DROPDOWN -->
                        <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                        <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                        <li class="dropdown dropdown-extended dropdown-tasks">
                            <?php
                             echo Html::a('เข้าสู่ระบบ <i class="icon-login"></i>', ['/auth/login'], [
                                'class' => 'dropdown-toggle',
                                'data-hover' => 'dropdown',
                                'data-close-others' => 'true',
                                'style' => 'padding-right: 16px;padding-top: 21px;font-size: 19px;',
                                'title' => 'เข้าสู่ระบบ',
                            ]); ?>
                        </li>
                        <!-- END QUICK SIDEBAR TOGGLER -->
                    <?php endif; ?>
                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>
        <!-- END PAGE TOP -->
    </div>
    <!-- END HEADER INNER -->
</div>
