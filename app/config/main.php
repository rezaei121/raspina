<?php
require 'db_config.php';

use \yii\web\Request;
$baseUrl = str_replace(['/app', '\\'], null, (new Request)->getBaseUrl());
return [
    'name' => 'Raspina',
    'id' => 'app',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'basePath' => dirname(__DIR__),
    'language' => 'en-US',
    'timeZone' => 'Asia/Tehran',
    'controllerNamespace' => 'app\controllers',
    'bootstrap' => ['log', 'debug', 'app\components\bootstrap\ModuleLoader', 'app\components\bootstrap\Setting'],
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'enableSchemaCache' => true,
            'schemaCache' => 'cache',
            'schemaCacheDuration' => 86400, // 24H it is in seconds
            'dsn' => DBMS . ':host=' . DB_HOST . ';dbname=' . DB_NAME,
            'username' => DB_USER_NAME,
            'password' => DB_PASSWORD,
            'charset' => 'utf8',
            'tablePrefix' => TBL_PREFIX,
        ],
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
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages'
                ],
                'template' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages'
                ],
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager'
        ],
        'assetManager' => [
            'basePath' => '@webroot/web/assets',
            'baseUrl' => '@web/app/web/assets',
        ],
        'request' => [
            'baseUrl' => '/raspina',
            'enableCsrfValidation' => false,
        ],
        'user' => [
            'identityClass' => 'app\modules\user\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['user/default/login'],
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
        'errorHandler' => [
            'errorAction' => 'site/error',
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
        'browser' => [
            'class' => 'common\components\browser',
        ],
        'setting' => [
            'class' => 'app\modules\setting\models\Setting',
        ],
        'render' => [
            'class' => 'common\components\render',
        ],
        'urlManager' => [
            'baseUrl' => '/raspina',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'pattern' => 'dashboard/site/captcha',
                    'route' => 'site/captcha',
                ],
                [
                    'pattern' => '<app:(dashboard)>/<module>/<controller>',
                    'route' => '<module>/<controller>',
                ],
                [
                    'pattern' => '<app:(dashboard)>/<module>',
                    'route' => '<module>',
                ],
                [
                    'pattern' => '<app:(dashboard)>/<module>/<action>',
                    'route' => '<module>/default/<action>',
                ],
                [
                    'pattern' => '<app:(dashboard)>/<module>/<controller>/<action>',
                    'route' => '<module>/<controller>/<action>',
                ],
//                // front start
                [
                    'pattern' => 'post/default/view/<id:\d+>/<title>',
                    'route' => 'post/default/view',
                    'suffix' => '.html',
                ],
                [
                    'pattern' => 'home/default/index/<category:\d+>/<title>',
                    'route' => 'home/default/index',
                    'suffix' => '.html',
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
                // front end
            ]
        ],
    ],
    'aliases' => [
        '@user_avatar' => '@app/files/avatar',
        '@file_upload' => '@app/files/upload',
//        '@template' => 'templates',
//        '@templateUrl' => 'frontend/views/templates',
        'templatePath' => '@app/themes',
    ],
    'params' => [],
];
