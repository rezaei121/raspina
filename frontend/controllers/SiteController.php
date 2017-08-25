<?php
namespace frontend\controllers;
use common\models\PostTag;
use common\models\Tag;
use frontend\models\Post;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
/**
 * Site controller
 */
class SiteController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
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
            'captcha' => [
                'class' => 'developit\captcha\CaptchaAction',
                'type' => 'numbers',
                'minLength' => 4,
                'maxLength' => 4,
            ],
        ];
    }

    public function actionError()
    {
        return $this->render('error');
    }

    public function actionRss()
    {
        $this->layout = 'blank.php';

        $posTable = \frontend\models\Post::tableName();
        $userTable = \common\models\User::tableName();

        $query = new Yii\db\Query();
        $posts = $query->select(["p.id","p.title","p.short_text","p.created_at","u.username"])->
        from("{$posTable} As p")->
        leftJoin("{$userTable} AS u","p.created_by = u.id")->
        groupBy("p.id")->
        orderBy('p.pin_post DESC,p.id DESC')->
        where("p.status=1")->limit($this->setting['page_size'])->all();
        return $this->render('../../site/rss.php', [
            'posts' => $posts
        ]);
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $query = new \yii\db\Query();
        $postModel = new Post;
        $posTable = \frontend\models\Post::tableName();
        $userTable = \common\models\User::tableName();
        $commentTable = \frontend\models\Comment::tableName();
        $postCategoryTable = \common\models\PostCategory::tableName();
        // update posts status
        $query->createCommand()->update($posTable,['status' => 1],"status = 2 AND created_at <='" . (new \DateTime())->format('Y-m-d H:i:s'). "'")->execute();

        // select posts
        $postModel = Post::find()
            ->alias('p')
            ->select(["p.*","COUNT(DISTINCT c.id) AS comment_count","IF(p.more_text != '','1','0') AS `more`","GROUP_CONCAT(DISTINCT pc.category_id) AS category_ids"])
            ->joinWith('createdBy u1')
            ->joinWith('updatedBy u2')
            ->leftJoin(['c' => $commentTable],"p.id = c.post_id AND c.status = 1")
            ->leftJoin(['pc' => $postCategoryTable],"p.id = pc.post_id")
            ->groupBy("p.id")
            ->orderBy('p.pin_post DESC,p.id DESC')
            ->where("p.status=1");

        $request = Yii::$app->request->get();

        if(isset($request['category']))
        {
            $postModel->andWhere(['pc.category_id' => $request['category']]);

            $catQuery = new \yii\db\Query();
            $categoryTable = \common\models\Category::tableName();
            $catResult = $catQuery->select("id")->from("{$categoryTable}")->where(['id' => $request['category'],'title' => $request['title']])->one();
            if(empty($catResult))
            {
                return $this->redirect(['site/error']);
            }
        }

        if(isset($request['tag']))
        {
            $postTagTableName = PostTag::tableName();
            $tagTableName = Tag::tableName();
            $postModel->leftJoin(['pt' => $postTagTableName], 'pt.post_id = p.id');
            $postModel->leftJoin(['t' => $tagTableName], 'pt.tag_id = t.id');
            $postModel->andWhere(['t.title' => $request['tag']]);
        }

        if(!empty($request['Site']['search']))
        {
            $postModel->andWhere(['like','p.title', $request['Site']['search']]);
            $postModel->orWhere(['like','p.short_text', $request['Site']['search']]);
            $postModel->orWhere(['like','p.more_text', $request['Site']['search']]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $postModel,
            'pagination' => [
                'pageSize' => $this->setting['page_size']
            ]
        ]);
//        var_dump($dataProvider); exit();
        return $this->render('posts', [
            'dataProvider' => $dataProvider
        ]);
    }
}