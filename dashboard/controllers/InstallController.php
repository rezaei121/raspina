<?php
namespace dashboard\controllers;

use dashboard\modules\setting\models\Setting;
use dashboard\modules\user\models\AuthAssignment;
use dashboard\modules\user\models\User;
use Yii;
use yii\base\DynamicModel;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Site controller
 */
class InstallController extends Controller
{
    /**
     * @inheritdoc
     */
//    private $_user;
//    public function behaviors()
//    {
//        return [
//            'access' => [
//                'class' => AccessControl::className(),
//                'only' => ['index', 'step1', 'step2', 'step3'],
//                'rules' => [
//                    [
//                        'actions' => ['index', 'step1', 'step2', 'step3'],
//                        'allow' => true,
//                        'roles' => ['?', '@'],
//                    ],
//                ],
//            ],
//        ];
//    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        $this->layout = 'install';
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'login-captcha' => [
                'class' => 'developit\captcha\CaptchaAction',
                'type' => 'numbers',
                'width' => '120',
                'height' => '34',
                'backColor' => 0x5292c6,
                'foreColor' => 0xFFFFFF,
                'minLength' => 5,
                'maxLength' => 5,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionStep1()
    {
        $model = new DynamicModel(['host', 'db_name', 'username', 'password', 'tb_prefix']);
        $model->addRule(['host', 'db_name', 'username', 'password', 'tb_prefix'], 'string', ['max' => 128])
        ->addRule(['host', 'db_name', 'username', 'password', 'tb_prefix'], 'required');

        $model->host = 'localhost';
        $model->tb_prefix = 'rs_';

        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            try
            {
                $db = new \PDO("mysql:host={$model->host};dbname={$model->db_name}",$model->username,$model->password);

                $db_config = '<?php' . "\n";
                $db_config .= "define('DBMS','mysql');\n";
                $db_config .= "define('DB_HOST','{$model->host}');\n";
                $db_config .= "define('DB_NAME','{$model->db_name}');\n";
                $db_config .= "define('DB_USER_NAME','{$model->username}');\n";
                $db_config .= "define('DB_PASSWORD','{$model->password}');\n";
                $db_config .= "define('TBL_PREFIX','{$model->tb_prefix}');\n";
                try
                {
                    if(!file_exists('../common/config/db_config.php'))
                    {
                        file_put_contents('../common/config/db_config.php',$db_config);
                        $sql = file_get_contents(Yii::getAlias('@common/files/db/raspina.sql'));
                        $sql = str_replace('rs_', $model->tb_prefix, $sql);
                        $db->query($sql)->execute();
                        $this->redirect(['step2']);
                    }
                    else
                    {
                        Yii::$app->session->setFlash('error', '[common/config/db_config.php] is exist. to continue, delete this file first');
                    }
                }
                catch (\Exception $e)
                {
                    Yii::$app->session->setFlash('error', $e->getMessage());
                }
        }
        catch (\Exception $e)
        {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        }

        return $this->render('step1', ['model' => $model]);
    }

    public function actionStep2()
    {
        $model = new Setting();
        $model->url = 'http://www.';
        $model->page_size = 20;
        $model->template = 'default';
        $model->date_format = 'HH:mm - yyyy/MM/dd';
        $model->sult = substr(md5(time()),0,10);

        if ($model->load(Yii::$app->request->post()))
        {
            $model->direction = $model->getLanguageDir($model->language);
            $model->save();
            $this->redirect(['step3']);
        }

        return $this->render('step2', ['model' => $model]);
    }

    public function actionStep3()
    {
        $model = new User();
        $model->scenario = 'create';
        $model->status = 10;

        if ($model->load(Yii::$app->request->post()))
        {
            $model->setPassword($model->password);
            $model->generateAuthKey();
            if($model->save())
            {
                $assignmentModel = new AuthAssignment;
                $assignmentModel->item_name = 'admin';
                $assignmentModel->user_id = $model->id;
                $assignmentModel->save();
            }
            $this->redirect(['/']);
        }

        return $this->render('step3', ['model' => $model]);
    }
}
