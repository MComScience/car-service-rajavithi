<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log','dektrium\user\Bootstrap'],
    'controllerNamespace' => 'frontend\controllers',
    'name' => 'โปรแกรมบริหารรถยนต์',
    'defaultRoute' => '/app/car/index',
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            'urlPrefix' => 'auth',
            'modelMap' => [
                'RegistrationForm' => 'metronic\user\models\RegistrationForm',
                'Profile' => 'metronic\user\models\Profile',
            ],
            'controllerMap' => [
                'admin' => 'metronic\user\controllers\AdminController',
                'settings' => 'metronic\user\controllers\SettingsController',
                'security' => [
                    'class' => 'metronic\user\controllers\SecurityController',
                    'layout' => '@metronic/views/layouts/main-login',
                ],
                'registration' => [
                    'class' => 'metronic\user\controllers\RegistrationController',
                    'layout' => '@metronic/views/layouts/main-login',
                ],
                'recovery' => [
                    'class' => 'metronic\user\controllers\RecoveryController',
                    'layout' => '@metronic/views/layouts/main-login',
                ],
            ],
        ],
        'rbac' => [
            'class' => 'mdm\admin\Module',
            'layout' => 'top-menu',
            'menus' => [
                'user' => null, // disable menu
                'menu' => null
            ],
        ],
        'gridview' =>  [
            'class' => '\kartik\grid\Module'
        ],
        'menu' => [
            'class' => 'metronic\menu\Module',
        ],
        'app' => [
            'class' => 'frontend\modules\app\Module',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => '',
        ],
        'user' => [
            'identityCookie' => [
                'name'     => '_frontendIdentity',
                'path'     => '/',
                'httpOnly' => true,
            ],
        ],
        'session' => [
            'name' => 'FRONTENDSESSID',
            'cookieParams' => [
                'httpOnly' => true,
                'path'     => '/',
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class' => 'yii\log\EmailTarget',
                    'mailer' => 'mailer',
                    'levels' => ['error'],
                    'categories' => ['yii\db\*'],
                    'message' => [
                       'from' => ['andamandev888@gmail.com'],
                       'to' => ['mcomsciencermu@gmail.com'],
                       'subject' => 'Log error message ระบบบริหารรถยนต์',
                    ],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'assetManager' => [
            'appendTimestamp' => true,
        ],
        'keyStorage' => [
            'class' => 'common\components\keyStorage\KeyStorage'
        ],
        'fileStorage' => [
            'class' => 'trntv\filekit\Storage',
            'baseUrl' => '@web/uploads',
            'filesystem' => [
                'class' => 'common\components\filesystem\LocalFlysystemBuilder',
                'path' => '@webroot/uploads'
            ],
            'as log' => [
                'class' => 'common\behaviors\FileStorageLogBehavior',
                'component' => 'fileStorage'
            ]
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@metronic/views',
                    '@dektrium/user/views' => '@metronic/user/views',
                ],
            ],
        ],
    ],
    /*'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            //'site/*',
            'admin/*',
            'user/security/*',
            'user/registration/*',
            'user/recovery/*',
        ],
    ],*/
    'params' => $params,
];
