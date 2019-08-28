<?php
$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'app\components\bootstrap\Setting'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@user_avatar' => '@app/files/avatar',
        '@file_upload' => '@app/files/upload',
//        '@template' => 'templates',
//        '@templateUrl' => 'frontend/views/templates',
        'templatePath' => '@app/themes',
//        '@app'   => '@vendor/npm-asset',
    ],
    'modules' => [
        'contact' => [
            'class' => 'app\modules\contact\Module',
        ],
        'user' => [
            'class' => 'app\modules\user\Module',
        ],
        'file' => [
            'class' => 'app\modules\file\Module',
        ],
        'link' => [
            'class' => 'app\modules\link\Module',
        ],
        'statistics' => [
            'class' => 'app\modules\statistics\Module',
        ],
        'template' => [
            'class' => 'app\modules\template\Module',
        ],
        'setting' => [
            'class' => 'app\modules\setting\Module',
        ],
        'post' => [
            'class' => 'app\modules\post\Module',
        ],
        'home' => [
            'class' => 'app\modules\home\Module',
        ],
    ],
    'components' => [
        'view' => [
            'class' => 'yii\web\View',
            'renderers' => [
                'twig' => [
                    'class' => 'yii\twig\ViewRenderer',
                    'cachePath' => '@runtime/Twig/cache',
                    // Array of twig options:
                    'options' => [
                        'auto_reload' => true,
                        'debug' => true,
                    ],
                    'globals' => [
                        'html' => ['class' => '\yii\helpers\Html'],
                        'raspina' => ['class' => '\app\components\helpers\Raspina'],
                        'captcha' => ['class' => '\developit\captcha\Captcha'],
                        'activeForm' => ['class' => '\yii\widgets\ActiveForm']
                    ],
                    'uses' => ['yii\bootstrap'],
                ],
            ]
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager'
        ],
        'hashids' => [
            'class' => 'light\hashids\Hashids',
            'salt' => '$atj@.14e*B4',
            'minHashLength' => 5,
            //'alphabet' => 'abcdefghigk'
        ],
        'date' => [
            'class' => 'app\components\date\Formatter',
            'locale' => 'fa-IR',
            'defaultTimeZone' => 'Asia/Tehran',
            'calendar' => \IntlDateFormatter::TRADITIONAL,
            'dateFormat' => 'php:Y-m-d',
            'datetimeFormat' => 'php:Y-m-d H:i',
            'timeFormat' => 'php:H:i',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '44gtu4YNDxGUg9rd_wTHjCcpP9Sh5Oaz',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\modules\user\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['user/default/login'],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'pattern' => 'dashboard/<module>/<controller>/<action>',
                    'route' => '<module>/dashboard/<controller>/<action>',
                ],
                [
                    'pattern' => 'dashboard/<module>/<action>',
                    'route' => '<module>/dashboard/<action>',
                ],
                [
                    'pattern' => 'dashboard/<module>',
                    'route' => '<module>/dashboard/index',
                ],
                [
                    'pattern' => 'file/default/download/<id>',
                    'route' => 'file/default/download',
                ],
                [
                    'pattern' => 'app/web/captcha',
                    'route' => 'site/captcha',
                ],
                [
                    'pattern' => '/post/index/<category:\d+>/<title>',
                    'route' => '/post/default/index',
                    'suffix' => '.html',
                ],
                [
                    'pattern' => '/dashboard',
                    'route' => '/statistics/dashboard/home',
                ],
                [
                    'pattern' => '/',
                    'route' => '/post/default/index',
                ],
                [
                    'pattern' => 'home/default/index/<tag>',
                    'route' => 'home/default/index',
                    'suffix' => '.html',
                ],
                [
                    'pattern' => 'user/default/about/<username>',
                    'route' => 'user/default/about',
                    'suffix' => '.html',
                ],
                [
                    'pattern' => 'post/view/<id:\d+>/<title>',
                    'route' => 'post/default/view',
                    'suffix' => '.html',
                ],
                [
                    'pattern' => 'post/default/share-link/<id>',
                    'route' => 'post/default/share-link',
                ],
                [
                    'pattern' => '<module>/<action>',
                    'route' => '<module>/default/<action>',
                ],
            ],
        ],
        'assetManager' => [
            'basePath' => '@webroot/web/assets',
            'baseUrl' => '@web/web/assets',
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
