<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@dektrium/user' => '@common/modules/yii2-user',
        '@mdm/admin' => '@common/modules/yii2-admin',
        '@metronic' => '@common/themes/metronic',
        '@metronic/user' => '@metronic/modules/yii2-user',
        '@metronic/sweetalert2' => '@metronic/widgets/yii2-sweetalert2',
        '@metronic/menu' => '@common/modules/yii2-menu',
        '@Mpdf' => '@common/lib/mpdf/src',
        '@unclead/multipleinput' => '@metronic/widgets/yii2-multiple-input',
        '@metronic/fullcalendar' => '@metronic/widgets/yii2-fullcalendar',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    # ตั้งค่าการใช้งานภาษาไทย (Language)
    'language' => 'th', // ตั้งค่าภาษาไทย
    # ตั้งค่า TimeZone ประเทศไทย
    'timeZone' => 'Asia/Bangkok', // ตั้งค่า TimeZone
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // or use 'yii\rbac\DbManager'
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'nullDisplay' => '',
            'dateFormat' => 'php:Y-m-d',
            'datetimeFormat' => 'php:Y-m-d H:i:s',
            'timeFormat' => 'php:H:i:s',
            'defaultTimeZone' => 'Asia/Bangkok',
            'timeZone' => 'Asia/Bangkok'
        ],
    ],
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableRegistration' => true,
            'enableUnconfirmedLogin' => true,
            'admins' => ['admin']
        ],
    ],
];
