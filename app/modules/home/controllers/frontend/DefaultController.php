<?php
namespace app\modules\home\controllers\frontend;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use app\modules\post\models\Post;

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
