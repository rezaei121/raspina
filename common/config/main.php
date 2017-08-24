<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'fa-IR',
    'timeZone' => 'Asia/Tehran',
    'components' => [
        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => [
                        'jquery.min.js'
                    ]
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [
                        'css/bootstrap.min.css',
                    ]
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => [
                        'js/bootstrap.min.js',
                    ]
                ]
            ],
        ],
        'view' => [
            'class' => 'yii\web\View',
            'renderers' => [
//                'twig' => [
//                    'cachePath' => false,
//                    'class' => 'yii\twig\ViewRenderer',
//                    'options' => YII_DEBUG ? [
//                        'debug' => true,
//                        'auto_reload' => true,
//                    ] : [],
//                    'extensions' => YII_DEBUG ? [
//                        '\Twig_Extension_Debug',
//                    ] : [],
//                    'globals' => [
//                        'html' => '\yii\helpers\Html',
//                    ],
//                    'functions' => array(
//                        'pdate' => 'Yii::$app->date->pdate',
//                        'Captcha_className' => '\yii\captcha\Captcha::className',
//                    ),
//                ]
            ],
            'theme' => [
                'basePath' => '@frontend/views/templates/default',
                'baseUrl' => '@frontend/views/templates/default',
                'pathMap' => [
                    '@frontend/templates' => '@frontend/views/templates',
                ],
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
          'class' => 'yii\rbac\DbManager'
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages'
                ],
                'template' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages'
                ],
            ],
        ],
        'hashids' => [
            'class' => 'light\hashids\Hashids',
            'salt' => '$atj@.14e*B4',
            'minHashLength' => 5,
            //'alphabet' => 'abcdefghigk'
        ],
        'date' => [
            'class' => 'common\components\date\Formatter',
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
            'class' => 'common\models\Setting',
        ],
        'render' => [
            'class' => 'common\components\render',
        ],
    ],
    'aliases' => [
        '@user_avatar' => '@common/files/avatar',
        '@file_upload' => '@common/files/upload',
        '@template' => 'templates',
        '@templateUrl' => 'frontend/views/templates',
        'templatePath' => '@frontend/views/templates',
    ]
];
