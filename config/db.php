<?php
require_once 'db_config.php';
return [
    'class' => 'yii\db\Connection',
    'enableSchemaCache' => true,
    'schemaCache' => 'cache',
    'schemaCacheDuration' => 86400, // 24H it is in seconds
    'dsn' => DBMS . ':host=' . DB_HOST . ';dbname=' . DB_NAME,
    'username' => DB_USER_NAME,
    'password' => DB_PASSWORD,
    'charset' => 'utf8',
    'tablePrefix' => TBL_PREFIX,

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
