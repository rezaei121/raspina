<?php
namespace frontend\controllers;
use common\components\CaptchaAction;
use Yii;
use backend\models\Post;
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
        $postModel = new \backend\models\Post();
        $query = $model = new \yii\db\Query();
        $posTable = Post::tableName();
        $userTable = \common\models\User::tableName();
        $commentTable = \backend\models\Comment::tableName();

        $model->select(["p.*","u.last_name","u.surname","COUNT(c.id) AS comment_count","IF(p.more_text IS NOT NULL,'1','0') AS `more`"])->
        from("{$posTable} As p")->leftJoin("{$userTable} AS u","p.author_id = u.id")->
        leftJoin("{$commentTable} AS c","p.id = c.post_id  AND c.status = 1")->
        where("p.id = {$id} AND p.title = '{$title}' AND p.status=1");
        $model = $model->one();

        if(empty($model['title']))
        {
            return $this->redirect(['site/error']);
        }

        $postModel->plusView($model['id']);

        if($model['tags'])
        {
            $model['tags'] = explode(',',$model['tags']);
        }

        if($model['keywords'])
        {
            $this->view->params['keywords'] = $model['keywords'];
        }

        if($model['meta_description'])
        {
            $this->view->params['description'] = $model['meta_description'];
        }

        $this->view->params['customParam'] = 'ehsan rezaee';
        $this->init();

        $commentModel = new \backend\models\Comment;
        $commentModel->ip = $_SERVER['REMOTE_ADDR'];
        $commentModel->scenario = 'post-view';
        // insert comment
        $commentModel->post_id = $id;
        $commentModel->create_time = time();

        $request = Yii::$app->request->post();

        if($commentModel->load($request) && $model['comment_active'] && $commentModel->save())
        {
            Yii::$app->getSession()->setFlash('success', Yii::t('app','Comment Successfully Sent'));
        }

        Yii::$app->view->title = $model['title'];
        return $this->render('post', [
            'model' => $model,
            'commentModel' => $commentModel,
            'comments' => $postModel->getPostComment($model['id']),
            'postModel' => $postModel,
            'postRelated' => $postModel->getRelated($model['id'], $model['title'])
        ]);
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
