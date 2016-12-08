<?php

namespace backend\controllers;

use backend\models\PostSearch;
use Yii;
use backend\models\Post;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
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
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Post();
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Post model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Post();
        $model->comment_active = true;
        $model->status = 1;
        $request = Yii::$app->request->post();
        $post_id = null;
        if(isset($request['Post']['post_id']) && $request['Post']['post_id'] != '')
        {
            $post_id = $request['Post']['post_id'];
            $model = $this->findModel((int)$post_id);
            unset($request['Post']['post_id']);
        }

        if ($model->load($request) && $model->validate())
        {
            $currentTime = time("now");
            $model->create_time = $currentTime;
            $model->author_id = Yii::$app->user->id;
            $model->tags = (isset($request['tags']) && !empty($request['tags']))? implode(',',$request['tags']) : null;
            $model->keywords = (isset($request['keywords']) && !empty($request['keywords']))? implode(',',$request['keywords']) : null;

            if($model->status == 2 && isset($request['Post']['date']))
            {
                $selectedTime = explode('/',$request['Post']['date']);
                $model->create_time = Yii::$app->date->jalali_to_gregorian($selectedTime[0],$selectedTime[1],$selectedTime[2],$request['Post']['hour'],$request['Post']['minute']);
                if($currentTime > $model->create_time)
                {
                    $model->status == 1;
                    $model->create_time = $currentTime;
                }
            }

            if(Yii::$app->request->isAjax)
            {
                $model->save();
                return $model->id;
            }

            if(!Yii::$app->request->isAjax && $model->save())
            {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        if(!Yii::$app->request->isAjax)
        {
            Yii::$app->session->setFlash('warning', Yii::t('app','Auto Save'));
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $request = Yii::$app->request->post();

        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $currentTime = time("now");
            $model->update_time = $currentTime;
            # set new tags
            if(isset($request['tags']))
            {
                $tags = explode(',',$model->tags);
                $model->tags = $model->setSelect2Value($request['tags'],$tags);
            }

            if(isset($request['keywords']))
            {
                $keywords = explode(',',$model->keywords);
                $model->keywords = $model->setSelect2Value($request['keywords'],$keywords);
            }

            if($model->status == 2 && isset($request['Post']['date']))
            {
                $selectedTime = explode('/',$request['Post']['date']);
                $model->create_time = Yii::$app->date->jalali_to_gregorian($selectedTime[0],$selectedTime[1],$selectedTime[2],$request['Post']['hour'],$request['Post']['minute']);
                if($currentTime > $model->create_time)
                {
                    $model->status == 1;
                    $model->create_time = $currentTime;
                }
            }

            if(Yii::$app->request->isAjax)
            {
                $model->save();
                return $model->id;
            }

            if(!Yii::$app->request->isAjax && $model->save())
            {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        if(!Yii::$app->request->isAjax)
        {
            Yii::$app->session->setFlash('warning', Yii::t('app','Auto Update'));
            $model->tags = explode(',',$model->tags);
            $model->keywords = explode(',',$model->keywords);
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Post model.
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
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
