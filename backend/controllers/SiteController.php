<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
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
                'only' => ['index','login','logout','changePassword','requestPasswordReset'],
                'rules' => [
                    [
                        'actions' => ['login','requestPasswordReset'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index','logout','login','changePassword','error'],
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
            'captcha' => [
                'class' => 'developit\captcha\CaptchaAction',
                'type' => 'numbers',
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
        # remove the clause ONLY_FULL_GROUP_BY
        $query = Yii::$app->getDb();
        $query->createCommand("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));")->query();

        $visitors = new \backend\models\Visitors;

        $posts = new \backend\models\Post;
        $postsDataProvider = new ActiveDataProvider([
            'query' => $posts->find()->where("view > 0")->orderBy('view DESC')->limit(10),
            'sort' => false,
            'pagination' => false
        ]);

        $files = new \backend\models\File;
        $filePostsDataProvider = new ActiveDataProvider([
            'query' => $files->find()->where("download_count > 0")->orderBy('download_count DESC')->limit(10),
            'sort' => false,
            'pagination' => false
        ]);

        $user = \common\models\User::findIdentity(Yii::$app->user->id);
        $user->avatar = \common\models\User::getAvatar();

        return $this->render('index',[
            'visitors' => $visitors->find()->orderBy('id DESC')->limit(20)->all(),
            'chart' => $visitors->chart(),
            'posts' => $postsDataProvider,
            'postModel' => $posts,
            'files' =>$filePostsDataProvider,
            'fileModel' => $files,
            'pie_chart' => $visitors->pie_chart(),
            'visit_period' => $visitors->visit_period(),
            'user' => $user,
        ]);
    }

    public function actionLogin()
    {
        $this->layout = 'login';
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        $model->scenario = 'user-login';
        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            $visitor = new\backend\models\Visitors;
            $visitor->delete();

            return $this->goHome();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $this->layout = 'login';
        $model = new \backend\models\PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', Yii::t('app','Check Your Email'));

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app','Unable To Reset Password'));
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        $this->layout = 'login';
        try {
            $model = new \backend\models\ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', Yii::t('app','New Password Was Saved'));

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
