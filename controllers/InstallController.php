<?php

namespace app\controllers;

use app\models\Install;
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
        return $this->render('index', ['model' => $model]);
    }

}
