<?php
namespace frontend\controllers;
use Yii;
use frontend\models\Newsletter;
use yii\filters\VerbFilter;
/**
 * NewsletterController implements the CRUD actions for Newsletter model.
 */
class NewsletterController extends BaseController
{
    public function actions()
    {
        $this->layout = $this->setting['layout'];
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
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
        $request = Yii::$app->request->post();
        if($model->load($request) && $model->save())
        {
            Yii::$app->getSession()->setFlash('success', Yii::t('app','Success join newsletter'));
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
                Yii::$app->session->setFlash('success', Yii::t('app','Success Unsubscribe Newsletter'));
            }
            else
            {
                Yii::$app->session->setFlash('error', Yii::t('app','Newsletter Email Not Found'));
            }
        }

        return $this->render('unsubscribe', [
            'model' => $model,
        ]);
    }
}
