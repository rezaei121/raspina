<?php
namespace app\modules\home\controllers\frontend;

use app\modules\post\models\Category;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use app\modules\post\models\Post;
use app\modules\post\models\Comment;
use app\modules\post\models\PostCategory;
use app\modules\post\models\PostTag;
use app\modules\post\models\Tag;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Default controller for the `posts` module
 */
class DefaultController extends Controller
{
    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        // select posts
        $postModel = Post::find()
            ->alias('p')
            ->select(["p.*","COUNT(DISTINCT c.id) AS comment_count","IF(p.more_text != '','1','0') AS `more`","GROUP_CONCAT(DISTINCT pc.category_id) AS category_ids"])
            ->joinWith('createdBy u1')
            ->joinWith('updatedBy u2')
            ->leftJoin(['c' => Comment::tableName()],"p.id = c.post_id AND c.status = 1")
            ->leftJoin(['pc' => PostCategory::tableName()],"p.id = pc.post_id")
            ->groupBy("p.id")
            ->orderBy(['p.pin_post' => SORT_DESC, 'p.id' => SORT_DESC])
            ->where(['p.status' => 1]);

        $request = Yii::$app->request->get();
        if(isset($request['category']))
        {
            $postModel->andWhere(['pc.category_id' => $request['category']]);
            $categoryModel = Category::findOne([['id' => $request['category'],'title' => $request['title']]]);
            if($categoryModel === null)
            {
                return $this->redirect(['site/error']);
            }
        }

        if(isset($request['tag']))
        {
            $postModel->leftJoin(['pt' => PostTag::tableName()], 'pt.post_id = p.id');
            $postModel->leftJoin(['t' => Tag::tableName()], 'pt.tag_id = t.id');
            $postModel->andWhere(['t.title' => $request['tag']]);
        }

        if(!empty($request['Post']['search']))
        {
            $postModel->andWhere(['like','p.title', $request['Post']['search']]);
            $postModel->orWhere(['like','p.short_text', $request['Post']['search']]);
            $postModel->orWhere(['like','p.more_text', $request['Post']['search']]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $postModel,
            'pagination' => [
                'pageSize' => Yii::$app->params['pageSize']
            ]
        ]);

        return $this->render('@theme/posts', [
            'dataProvider' => $dataProvider
        ]);
    }
}
