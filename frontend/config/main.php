<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);
use \yii\web\Request;
$baseUrl = str_replace('/frontend/web', '', (new Request)->getBaseUrl());
//$baseUrl = (new Request)->getBaseUrl();
return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'baseUrl' => $baseUrl,
            'enableCsrfValidation' => false,
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
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
        'urlManager' => [
            'baseUrl' => $baseUrl,
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'file/download/<id:\w+>' => 'file/download',
                'site/index/tag/<tag>/<page:\d+>/<per-page:\d+>' => 'site/index',
                'site/index/tag/<tag>' => 'site/index',
                'site/404.html' => 'site/404',
                [
                    'pattern' => 'post/view/<id:\d+>/<title>',
                    'route' => 'post/view',
                    'suffix' => '.html',
                ],
                [
                    'pattern' => 'site/index/category/<category:\d+>/<title>/<page:\d+>/<per-page:\d+>',
                    'route' => 'site/index',
                    'suffix' => '.html'
                ],
                [
                    'pattern' => 'site/index/category/<category:\d+>/<title>',
                    'route' => 'site/index',
                    'suffix' => '.html'
                ],
                'site/index/<page:\d+>/<per-page:\d+>' => 'site/index',
            ]
        ]
    ],
    'params' => $params,
    'aliases' => [
        '@assetUrl' => (new Request)->getBaseUrl()
    ]
];
