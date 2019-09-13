<?php
require_once 'db_config.php';

$config = [
    'class' => 'yii\db\Connection',
    'dsn' => DBMS . ':host=' . DB_HOST . ';dbname=' . DB_NAME,
    'username' => DB_USER_NAME,
    'password' => DB_PASSWORD,
    'charset' => 'utf8',
    'tablePrefix' => TBL_PREFIX,
];

if (!YII_ENV_DEV) {
    $config['enableSchemaCache'] = true;
    $config['schemaCache'] = 'cache';
    $config['schemaCacheDuration'] = 86400; // 24H it is in seconds
}

return $config;
