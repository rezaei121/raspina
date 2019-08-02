<?php
namespace app\controllers;

use app\components\Controller;
use Yii;
use yii\filters\VerbFilter;

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
            'captcha' => [
                'class' => 'developit\captcha\CaptchaAction',
                'type' => 'numbers',
//                'width' => '120',
//                'height' => '34',
                'backColor' => 0xFFFFFF,
                'foreColor' => 0x666666,
                'minLength' => 5,
                'maxLength' => 5,
            ],
        ];
    }

    public function actionError()
    {
        $this->module->layoutPath = '@theme';
        $this->layout = 'main.twig';
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('@theme/error.twig', ['exception' => $exception]);
        }
    }

    public function beforeAction($action)
    {
        return parent::beforeAction($action);
    }
}
