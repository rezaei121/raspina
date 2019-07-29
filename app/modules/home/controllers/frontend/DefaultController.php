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
        $postModel = Post::getAll(Yii::$app->request->get());
        $dataProvider = new ActiveDataProvider([
            'query' => $postModel,
            'pagination' => [
                'pageSize' => Yii::$app->params['pageSize']
            ]
        ]);

        return $this->render('@theme/posts.twig', [
            'dataProvider' => $dataProvider
        ]);
    }
}
