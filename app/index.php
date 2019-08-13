<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/components/functions.php');

$appName = getAppName();
require(__DIR__ . "/config/{$appName}/bootstrap.php");
$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . "/config/{$appName}/main.php"),
    require(__DIR__ . "/config/{$appName}/main-local.php")
);

$application = new yii\web\Application($config);
$application->run();
