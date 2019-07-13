<?php
/**
 * Application _config for common unit tests
 */
return yii\helpers\ArrayHelper::merge(
    require(YII_APP_BASE_PATH . '/common_tml/_config/main.php'),
    require(YII_APP_BASE_PATH . '/common_tml/_config/main-local.php'),
    require(dirname(__DIR__) . '/config.php'),
    require(dirname(__DIR__) . '/unit.php'),
    [
        'id' => 'app-common',
        'basePath' => dirname(__DIR__),
    ]
);
