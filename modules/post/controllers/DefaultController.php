<?php
namespace app\modules\post\controllers;
use app\modules\post\models\Comment;
use app\modules\post\models\Post;
use app\modules\statistics\models\Visitor;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use Yii;
use yii\web\NotFoundHttpException;


/**
 * Default controller for the `posts` module
 */
class DefaultController extends \app\components\Controller
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
        $this->module->layoutPath = Yii::$app->params['templateLayout'];
        $this->layout = 'main.twig';
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $postModel = Post::getAll(Yii::$app->request->get());
        $dataProvider = new ActiveDataProvider([
            'query' => $postModel,
        ]);

        return $this->render('@theme/posts.twig', [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Displays a single Post model.
     * @param string $id
     * @return mixed
     */
    public function actionShareLink($id)
    {
        $id = Yii::$app->hashids->decode($id);
        if(isset($id[0]))
        {
            $postModel = Post::findOne($id[0]);
            if($postModel !== null)
            {
                $this->redirect(['view', 'id' => $id[0], 'title' => $postModel->slug]);
            }
        }
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

        $this->view->params['keywords'] = $postModel->keywords;
        $this->view->params['description'] = $postModel->meta_description;

        $commentModel = new Comment();
        $commentModel->scenario = 'post-view';
        // insert comment
        $commentModel->ip = $_SERVER['REMOTE_ADDR'];
        $commentModel->post_id = $id;

        $request = Yii::$app->request->post();
        if($commentModel->load($request) && $postModel->enable_comments)
        {
            if(Visitor::isValid())
            {
                if($commentModel->save())
                {
                    Yii::$app->getSession()->setFlash('success', Yii::t('app','Comment successfully sent'));
                    $commentModel = new Comment();
                }
            }
            else
            {
                Yii::$app->getSession()->setFlash('warning', Yii::t('app','You are not a valid user and cannot activity!'));
            }
        }

        return $this->render('@theme/post.twig', [
            'model' => $postModel,
            'commentModel' => $commentModel,
        ]);
    }

    public function actionRss()
    {
        $this->module->layoutPath = '';
        $this->layout = '@app/views/layouts/blank';

        $posts = Post::find()
            ->select(["p.id","p.title","p.short_text","p.created_at","u.username"])
            ->alias('p')
            ->leftJoin("{{%user}} AS u","p.created_by = u.id")
            ->groupBy("p.id")
            ->orderBy(['p.pin_post' => SORT_DESC, 'p.id' => SORT_DESC])
            ->where(['p.status' => Post::PUBLISH_STATUS])
            ->limit(Yii::$app->params['pageSize'])
            ->all();

        return $this->render('@theme/rss.twig', [
            'posts' => $posts
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
        if (($model = Post::findOne(['id' => $id, 'slug' => $title])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
