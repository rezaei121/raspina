<?php
namespace frontend\controllers;
use Yii;
use frontend\models\Post;
use yii\behaviors\SluggableBehavior;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends BaseController
{
    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                'slugAttribute' => 'slug',
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        $this->layout = $this->setting['layout'];
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays a single Post model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id,$title)
    {
        $postModel = $this->findModel($id,$title);
        $postModel->plusView();
        $model = $postModel->get();

//        $model->tags = !empty($model->tags)? explode(',',$model->tags) : null;
        $this->view->params['keywords'] = $model->keywords;
        $this->view->params['description'] = $model->meta_description;

        $commentModel = new \frontend\models\Comment;
        // insert comment
        $commentModel->ip = $_SERVER['REMOTE_ADDR'];
        $commentModel->post_id = $id;

        $request = Yii::$app->request->post();
        if($commentModel->load($request) && $model['enable_comments'] && $commentModel->save())
        {
            Yii::$app->getSession()->setFlash('success', Yii::t('app','Comment Successfully Sent'));
        }

        return $this->render('post', [
            'post' => $model,
            'commentModel' => $commentModel,
            'comments' => $postModel->getComments()->all(),
            'postCategories' => $postModel->getPostCategories()->all()
        ]);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id,$title)
    {
        if (($model = Post::findOne(['id' => $id, 'title' => $title])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
