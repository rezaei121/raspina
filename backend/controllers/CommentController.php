<?php

namespace backend\controllers;

use Yii;
use backend\models\Comment;
use backend\models\CommentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * CommentController implements the CRUD actions for Comment model.
 */
class CommentController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','view','delete','create','update','bulk'],
                'rules' => [
                    [
                        'actions' => ['index','view','delete','create','update','bulk'],
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


//    public function actions()
//    {
////        $this->layout = $this->setting['layout'];
//        return [
//            'error' => [
//                'class' => 'yii\web\ErrorAction',
//            ],
//            'captcha' => [
//                'class' => 'yii\captcha\CaptchaAction2',
//                'minLength' => 3,
//                'maxLength' => 3,
//                'width' => 50,
//            ],
//        ];
//    }
    /**
     * Lists all Comment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Comment();
        $searchModel = new CommentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }

    /**
     * Displays a single Comment model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = Comment::find()->alias('comment')->joinWith('post')->where("comment.id={$id}")->one();
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Comment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Comment();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Comment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'comment-reply';
        Yii::$app->session->setFlash('warning', Yii::t('app','Auto Accept'));
        if ($model->load(Yii::$app->request->post())) {
            $model->status = 1;
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Comment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionBulk()
    {
        $GETrequest = Yii::$app->request->get();
        $selection = isset($GETrequest['id'])? (array)$GETrequest['id'] : (array)Yii::$app->request->post('selection');
        $action = isset($GETrequest['action'])? $GETrequest['action'] : Yii::$app->request->post('action');

        if($action == 'confirmed')
        {
            Comment::updateAll(['status' => 1],['id'=>$selection]);
            Yii::$app->session->setFlash('success', Yii::t('app','Confirmed Successfully Applied'));
        }

        if($action == 'delete')
        {
            Comment::deleteAll(['id'=>$selection]);
            Yii::$app->session->setFlash('success', Yii::t('app','Delete Successfully Applied'));
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Comment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Comment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Comment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
