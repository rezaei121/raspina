<?php

namespace app\controllers;

use app\models\Install;
use app\modules\setting\models\Setting;
use app\modules\user\models\AuthAssignment;
use app\modules\user\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class InstallController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
//        $this->module->layoutPath = Yii::$app->params['templateLayout'];
        $this->layout = 'install.php';
//        $this->viewPath = Yii::$app->params['templateLayout'];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new Install();
        $model->dbms = 'mysql';
        $model->db_host = 'localhost';
        $model->table_prefix = 'rs_';
        $model->url = 'http://www.';

        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $dbConfig = '<?php' . "\n";
            $dbConfig .= "define('DBMS','{$model->dbms}');\n";
            $dbConfig .= "define('DB_HOST','{$model->db_host}');\n";
            $dbConfig .= "define('DB_NAME','{$model->db_name}');\n";
            $dbConfig .= "define('DB_USER_NAME','{$model->db_username}');\n";
            $dbConfig .= "define('DB_PASSWORD','{$model->db_password}');\n";
            $dbConfig .= "define('TBL_PREFIX','{$model->table_prefix}');\n";


            // if(!file_exists(Yii::getAlias('@webroot') . '/config/db_config.php'))
            {
                file_put_contents(Yii::getAlias('@webroot') . '/config/db_config.php',$dbConfig);
                $model->runMigration();

                $settingModel = new Setting();
                $settingModel->title = $model->title;
                $settingModel->description = $model->description;
                $settingModel->language = 'fa-IR';
                $settingModel->time_zone = '';
                $settingModel->page_size = 20;
                $settingModel->template = 'default';
                $settingModel->date_format = 'HH:mm - yyyy/MM/dd';
                $settingModel->sult = substr(md5(time()),0,10);
                $settingModel->direction = $settingModel->getLanguageDir($settingModel->language);
                $settingModel->save(false);

                $userModel = new User();
                $userModel->scenario = 'create';
                $userModel->status = 10;
                $userModel->username = $model->username;
                $userModel->last_name = $model->last_name;
                $userModel->surname = $model->surname;
                $userModel->email = $model->email;
                $userModel->setPassword($model->password);
                $userModel->generateAuthKey();
                $userModel->save(false);

//                $assignmentModel = new AuthAssignment();
//                $assignmentModel->item_name = 'admin';
//                $assignmentModel->user_id = $userModel->id;
//                $assignmentModel->save(false);
            }
//            else
//            {
//                Yii::$app->session->setFlash('error', '[config/db_config.php] is exist. to continue, delete this file first');
//            }
        }

        return $this->render('index', ['model' => $model]);
    }

}
