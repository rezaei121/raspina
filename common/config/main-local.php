<?php
if(file_exists(Yii::getAlias('@common/config/db_config.php')))
{
    require 'db_config.php';
    return [
        'components' => [
            'db' => [
                'class' => 'yii\db\Connection',
                'dsn' => DBMS . ':host=' . DB_HOST . ';dbname=' . DB_NAME,
                'username' => DB_USER_NAME,
                'password' => DB_PASSWORD,
                'charset' => 'utf8',
                'tablePrefix' => TBL_PREFIX,
            ],
            'mailer' => [
                'class' => 'yii\swiftmailer\Mailer',
                'viewPath' => '@common/mail',
//                'transport' => [
//                    'class' => 'Swift_SmtpTransport',
//                    'host' => 'smtp.gmail.com',
//                    'username' => 'your_mail@gmail.com',
//                    'password' => 'your password',
//                    'port' => '587',
//                    'encryption' => 'tls',
//                ],

                // send all mails to a file by default. You have to set
                // 'useFileTransport' to false and configure a transport
                // for the mailer to send real emails.
                'useFileTransport' => false,
            ],
        ],
    ];
}
else
{
    return [];
}
