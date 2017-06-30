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
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'post' => [
            'class' => 'backend\modules\post\post',
        ],
        'newsletter' => [
            'class' => 'backend\modules\newsletter\newsletter',
        ],
        'link' => [
            'class' => 'backend\modules\link\link',
        ],
        'file' => [
            'class' => 'backend\modules\file\file',
        ],
        'contact' => [
            'class' => 'backend\modules\contact\contact',
        ],
        'about' => [
            'class' => 'backend\modules\about\about',
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
