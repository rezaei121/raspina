<?php
namespace dashboard\modules\post\controllers;

use Yii;
use yii\web\Controller;
use dashboard\modules\post\models\PostSearch;
use dashboard\modules\post\models\Post;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Default controller for the `posts` module
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
                        'roles' => ['author'],
                    ]
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

    protected function fillModel($model)
    {
        $request = Yii::$app->request->post();
        $model->tags = (isset($request['tags']) && !empty($request['tags'])) ? implode(',', $request['tags']) : null;
        $model->keywords = (isset($request['keywords']) && !empty($request['keywords'])) ? implode(',', $request['keywords']) : null;

        return $model;
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Post;
        $model->enable_comments = 1;
        $model->status = 1;

        $request = Yii::$app->request->post();

        if ($model->load($request) && $model->validate())
        {
            $model = $this->fillModel($model);
            if($model->save())
            {
                Yii::$app->session->setFlash('success', Yii::t('app','{object} created.',[
                    'object' => Yii::t('app','Post')
                ]));
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
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

        if(!Yii::$app->user->can('updatePost', ['model' => $model]))
        {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }

        $request = Yii::$app->request->post();
        if ($model->load($request) && $model->validate())
        {

            if($model->save())
            {
                Yii::$app->session->setFlash('success', Yii::t('app','{object} updated.',[
                    'object' => Yii::t('app','Post')
                ]));
                return $this->redirect(['view', 'id' => $model->id]);
            }

        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionAutoSave()
    {
        if(!Yii::$app->request->isAjax)
        {
            return false;
        }

        $model = new Post();
        $post_id = null;
        $request = Yii::$app->request->post();
        if(isset($request['Post']['post_id']) && $request['Post']['post_id'] != '')
        {
            $post_id = $request['Post']['post_id'];
            $model = $this->findModel((int)$post_id);
        }

        if ($model->load($request) && $model->validate())
        {
            $model = $this->fillModel($model);

            if($model->status == 1)
            {
                $model->status = 0;
            }

            if($model->save())
            {
                return $model->id;
            }
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
        $model = $this->findModel($id);

        if(!Yii::$app->user->can('deletePost', ['model' => $model]))
        {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }

        $model->delete();
        Yii::$app->session->setFlash('success', Yii::t('app','{object} deleted.',[
            'object' => Yii::t('app','Post')
        ]));
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
