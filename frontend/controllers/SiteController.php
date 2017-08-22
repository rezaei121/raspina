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

        $posTable = \frontend\models\Post::tableName();
        $userTable = \common\models\User::tableName();
        $commentTable = \frontend\models\Comment::tableName();
        $postCategoryTable = \common\models\PostCategory::tableName();
        // update posts status
        $query->createCommand()->update($posTable,['status' => 1],"status = 2 AND created_at <='" . (new \DateTime())->format('Y-m-d H:i:s'). "'")->execute();

        // select posts
        $query->select(["p.pin_post","p.id","p.title","p.short_text","p.created_at","p.view","u.last_name","u.surname","COUNT(DISTINCT c.id) AS comment_count","IF(p.more_text != '','1','0') AS `more`","GROUP_CONCAT(DISTINCT pc.category_id) AS category_ids"])->
        from("{$posTable} As p")->
        leftJoin("{$userTable} AS u","p.created_by = u.id")->
        leftJoin("{$commentTable} AS c","p.id = c.post_id AND c.status = 1")->
        leftJoin("{$postCategoryTable} AS pc","p.id = pc.post_id")->
        groupBy("p.id")->
        orderBy('p.pin_post DESC,p.id DESC')->
        where("p.status=1");

        $request = Yii::$app->request->get();

        if(isset($request['category']))
        {
            $query->andWhere(['pc.category_id' => $request['category']]);

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
            $query->andWhere(['like','p.tags', $request['tag']]);
        }

        if(!empty($request['Site']['search']))
        {
            $query->andWhere(['like','p.title', $request['Site']['search']]);
            $query->orWhere(['like','p.short_text', $request['Site']['search']]);
            $query->orWhere(['like','p.more_text', $request['Site']['search']]);
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