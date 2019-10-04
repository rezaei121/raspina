<?php
namespace app\modules\post\controllers\dashboard;

use app\modules\post\models\Post;
use app\modules\post\models\PostSearch;
use Yii;
use yii\data\Sort;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Default controller for the `posts` module
 */
class ParagraphController extends \app\components\Controller
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['author', 'moderator', 'admin'],
                    ]
                ],
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
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $postModel = Post::find()->limit(10)->orderBy(['id' => SORT_DESC])->all();

        $result = [];
        $re = '%(<p[^>]*>.*?</p>)%i';
        foreach ($postModel as $post)
        {
            $text = $post->short_text . $post->more_text;
            preg_match_all($re, $text, $matches, PREG_OFFSET_CAPTURE, 0);
            $result[] = [
                'title' => $post->title,
                'paragraphs' => $matches[0]
            ];
        }

        return $this->render('index', [
            'result' => $result,
        ]);
    }
}
