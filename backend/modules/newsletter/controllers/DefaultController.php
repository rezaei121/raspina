<?php

namespace backend\modules\newsletter\controllers;

use Yii;
use backend\modules\newsletter\models\Newsletter;
use backend\modules\newsletter\models\NewsletterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;

/**
 * NewsletterController implements the CRUD actions for Newsletter model.
 */
class DefaultController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','create','update','delete','view'],
                'rules' => [
                    [
                        'actions' => ['index','create','update','delete','view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Newsletter models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NewsletterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Newsletter model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Newsletter();
        $request = Yii::$app->request->post();
        if ($model->load($request))
        {
            $compose = $model->send(['title' => $request['Newsletter']['title'], 'content' => $request['Newsletter']['text']]);
            if($compose)
            {
                Yii::$app->getSession()->setFlash('success',Yii::t('app','Success Sending Newsletter'));
            }
            else
            {
                Yii::$app->getSession()->setFlash('error',Yii::t('app','Error Sending Newsletter'));
            }

            return $this->redirect(['index', 'id' => $model->id]);
        }
        else
        {
            $query = Newsletter::find()->limit(10);
            $getRequest = Yii::$app->request->get();
            if(!isset($getRequest['sort']))
            {
                $query->orderBy('id DESC');
            }
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
            ]);
            return $this->render('create', [
                'model' => $model,
                'dataProvider' => $dataProvider
            ]);
        }
    }
    /**
     * Deletes an existing Newsletter model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Newsletter model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Newsletter the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Newsletter::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionBulk()
    {
        $action = Yii::$app->request->post('action');
        $selection=(array)Yii::$app->request->post('selection');

        if($action == 'delete')
        {
            Newsletter::deleteAll(['id'=>$selection]);
            Yii::$app->session->setFlash('success', Yii::t('app','Delete Successfully Applied'));
        }

        return $this->redirect(['index']);
    }
}
