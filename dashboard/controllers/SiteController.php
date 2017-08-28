<?php
namespace dashboard\controllers;

use dashboard\modules\user\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
//use frontend\models\PasswordResetRequestForm;
//use frontend\models\ResetPasswordForm;
use yii\helpers\Url;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    private $_user;
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'login','requestPasswordReset'],
                'rules' => [
                    [
                        'actions' => ['login','requestPasswordReset'],
                        'allow' => true,
                        'roles' => ['?', '@'],
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
//                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
//            'captcha' => [
//                'class' => 'developit\captcha\CaptchaAction',
//                'type' => 'numbers',
//                'minLength' => 4,
//                'maxLength' => 4,
//            ],
            'login-captcha' => [
                'class' => 'developit\captcha\CaptchaAction',
                'type' => 'numbers',
                'width' => '120',
                'height' => '34',
                'backColor' => 0x5292c6,
                'foreColor' => 0xFFFFFF,
                'minLength' => 4,
                'maxLength' => 4,
            ],
        ];
    }

    public function beforeAction($action)
    {
        if ($action->id == 'error')
        {
            if (Yii::$app->user->isGuest)
            {
                return Yii::$app->getResponse()->redirect(Url::to(\Yii::$app->getUser()->loginUrl))->send();
            }
        }
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
//        var_dump(date_default_timezone_get());
//        exit();
        # remove the clause ONLY_FULL_GROUP_BY
        $query = Yii::$app->getDb();
        $query->createCommand("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));")->query();

        $visitors = new \common\models\Visitors;

        $posts = new \dashboard\modules\post\models\Post;
        $postsDataProvider = new ActiveDataProvider([
            'query' => $posts->find()->where("view > 0")->orderBy('view DESC')->limit(10),
            'sort' => false,
            'pagination' => false
        ]);

        $files = new \dashboard\modules\file\models\File;
        $filePostsDataProvider = new ActiveDataProvider([
            'query' => $files->find()->where("download_count > 0")->orderBy('download_count DESC')->limit(10),
            'sort' => false,
            'pagination' => false
        ]);

        $user = User::findIdentity(Yii::$app->user->id);
        $user->avatar = User::getAvatar(Yii::$app->user->id);

        return $this->render('index',[
            'visitorsModel' => $visitors,
            'visitors' => $visitors->find()->orderBy('id DESC')->limit(100)->all(),
            'chart' => $visitors->chart(),
            'posts' => $postsDataProvider,
            'postModel' => $posts,
            'files' =>$filePostsDataProvider,
            'fileModel' => $files,
            'user' => $user,
        ]);
    }
}
