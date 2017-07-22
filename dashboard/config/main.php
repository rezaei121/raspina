<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

use \yii\web\Request;
$baseUrl = str_replace('/frontend/web', '', (new Request)->getBaseUrl());
return [
    'id' => 'app-dashboard',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'dashboard\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'post' => [
            'class' => 'dashboard\modules\post\post',
        ],
        'newsletter' => [
            'class' => 'dashboard\modules\newsletter\newsletter',
        ],
        'link' => [
            'class' => 'dashboard\modules\link\link',
        ],
        'file' => [
            'class' => 'dashboard\modules\file\file',
        ],
        'contact' => [
            'class' => 'dashboard\modules\contact\contact',
        ],
        'about' => [
            'class' => 'dashboard\modules\about\about',
        ],
        'statistics' => [
            'class' => 'dashboard\modules\statistics\statistics',
        ],
    ],
    'components' => [
        'request' => [
            'baseUrl' => $baseUrl,
            'enableCsrfValidation' => false,
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['user/login'],
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
            'rules' => []
        ],
    ],
    'params' => $params,
];
