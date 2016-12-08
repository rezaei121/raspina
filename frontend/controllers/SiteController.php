<?php
namespace frontend\controllers;
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

//    public function beforeAction($action)
//    {
//        if ($action->id == 'error')
//        {
//            if (Yii::$app->user->isGuest)
//            {
//                return Yii::$app->getResponse()->redirect(Url::to(\Yii::$app->getUser()->loginUrl))->send();
//            }
//        }
//        return parent::beforeAction($action);
//    }

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

        $posTable = \backend\models\Post::tableName();
        $userTable = \common\models\User::tableName();

        $query = new Yii\db\Query();
        $posts = $query->select(["p.id","p.title","p.short_text","p.create_time","u.username"])->
        from("{$posTable} As p")->
        leftJoin("{$userTable} AS u","p.author_id = u.id")->
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

        $posTable = \backend\models\Post::tableName();
        $userTable = \common\models\User::tableName();
        $commentTable = \backend\models\Comment::tableName();
        $postCategoryTable = \backend\models\PostCategory::tableName();

        // update posts status
        $query->createCommand()->update($posTable,['status' => 1],"status = 2 AND create_time <=" . time())->execute();

        // select posts
        $query->select(["p.pin_post","p.id","p.title","p.short_text","p.create_time","p.view","u.last_name","u.surname","COUNT(DISTINCT c.id) AS comment_count","IF(p.more_text != '','1','0') AS `more`","GROUP_CONCAT(DISTINCT pc.category_id) AS category_ids"])->
        from("{$posTable} As p")->
        leftJoin("{$userTable} AS u","p.author_id = u.id")->
        leftJoin("{$commentTable} AS c","p.id = c.post_id AND c.status = 1")->
        leftJoin("{$postCategoryTable} AS pc","p.id = pc.post_id")->
        groupBy("p.id")->
        orderBy('p.pin_post DESC,p.id DESC')->
        where("p.status=1");

        $request = Yii::$app->request->get();

        if(isset($request['category']))
        {
            $query->andWhere("pc.category_id={$request['category']}");

            $catQuery = new \yii\db\Query();
            $categoryTable = \backend\models\Category::tableName();
            $catResult = $catQuery->select("id")->from("{$categoryTable}")->where("id={$request['category']} AND title = '{$request['title']}'")->one();
            if(empty($catResult))
            {
                return $this->redirect(['site/error']);
            }
            Yii::$app->view->title = $request['title'];
        }

        if(isset($request['tag']))
        {
            $query->andWhere("p.tags LIKE '%{$request['tag']}%'");
        }

        if(!empty($request['Site']['search']))
        {
            $query->andWhere("p.title LIKE '%{$request['Site']['search']}%' OR p.short_text LIKE '%{$request['Site']['search']}%' OR p.more_text LIKE '%{$request['Site']['search']}%'");
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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