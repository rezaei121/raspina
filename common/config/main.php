<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'fa-IR',
    'timeZone' => 'Asia/Tehran',
    'components' => [
        'assetManager' => [
//            'linkAssets' => true,
//            'forceCopy' => true,
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
            ],
        ],
        'hashids' => [
            'class' => 'light\hashids\Hashids',
            'salt' => '$atj@.14e*B4',
            'minHashLength' => 5,
            //'alphabet' => 'abcdefghigk'
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'locale' => 'fa_IR@calendar=persian',
            'dateFormat' => 'php:d-M-Y',
            'datetimeFormat' => 'php:d-M-Y H:i:s',
            'timeFormat' => 'php:H:i:s',
        ],
        'date' => [
            'class' => 'developit\pdate\DateTime',
        ],
        'browser' => [
            'class' => 'common\components\browser',
        ],
        'setting' => [
            'class' => 'common\components\setting',
        ],
        'render' => [
            'class' => 'common\components\render',
        ],
    ],
    'aliases' => [
        '@user_avatar' => '@common/files/avatar',
        '@file_upload' => '@common/files/upload',
        '@template' => 'template',
        '@templateUrl' => 'frontend/views/template'
    ]
];
