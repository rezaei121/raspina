<?php

namespace app\models;

use app\components\Model;
use Yii;

/**
 * ContactForm is the model behind the contact form.
 */
class Install extends Model
{
    public $dbms;
    public $db_host;
    public $db_name;
    public $db_username;
    public $db_password;
    public $table_prefix;

    public $username;
    public $password;
    public $re_password;
    public $email;
    public $last_name;
    public $surname;

    public $url;
    public $title;
    public $description;
    public $language;
    public $time_zone;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['dbms', 'db_host', 'db_name', 'db_username', 'username', 'password', 're_password', 'email', 'url', 'title', 'description', 'language', 'time_zone', 'last_name', 'surname'], 'required'],
            ['email', 'email'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'dbms' => 'DBMS',
            'db_host' => 'Database Host',
            'db_name' => 'Database Name',
            'db_username' => 'Database Username',
            'db_password' => 'Database Password',
            'table_prefix' => 'Table Prefix',
            'username' => 'Username',
            'password' => 'Password',
            're_password' => 'Re Password',
            'email' => 'Email',
            'url' => 'Url',
            'title' => 'Title',
            'description' => 'Description',
            'language' => 'Language',
            'time_zone' => 'Time Zone',
        ];
    }
}
