<?php

namespace frontend\controllers;

use frontend\controllers\BaseController;
use Yii;
use frontend\models\Newsletter;
//use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
//use yii\widgets\ActiveForm;
//use yii\web\Controller;
/**
 * NewsletterController implements the CRUD actions for Newsletter model.
 */
class NewsletterController extends BaseController
{
    public $layout = '';
    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->layout = $this->setting['layout'];
    }

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * join user Newsletter.
     * @return mixed
     */
    public function actionJoin()
    {
        $model = new Newsletter();
        $model->scenario = 'join';
        $request = Yii::$app->request->post();
        if($model->load($request) && $model->validate())
        {
            if($model->save())
            {
                Yii::$app->getSession()->setFlash('success', Yii::t('app','Success Join Newsletter'));
            }

        }
        else
        {
            $error = $model->errors;
            if(!empty($error))
            {
                Yii::$app->getSession()->setFlash('error', $error['email'][0]);
            }
        }
        return $this->redirect(['site/index']);
    }

    public function actionUnsubscribe()
    {
        $model = new Newsletter();
        $model->scenario = 'unsubscribe';

        $request = Yii::$app->request->post();
        if($model->load($request) && $model->validate())
        {
            $findModel = $model->findOne(['email' => $model->email]);
            if($findModel !== null)
            {
                $findModel->delete();
                \Yii::$app->getSession()->setFlash('message', [
                    'text' => Yii::t('app','Success Unsubscribe Newsletter'),
                    'class' => 'success'
                ]);
            }
            else
            {
                \Yii::$app->getSession()->setFlash('message', [
                    'text' => Yii::t('app','Newsletter Email Not Found'),
                    'class' => 'error'
                ]);
            }
        }

        return $this->render('unsubscribe.twig', [
            'model' => $model,
        ]);
    }
}
