<?php
namespace app\modules\home\controllers\dashboard;

use app\modules\statistics\models\Visitor;
use app\components\Controller;
use yii\filters\AccessControl;

/**
 * Default controller for the `posts` module
 */
class DefaultController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $visitors = new Visitor;
        return $this->render('index',[
            'visitorsModel' => $visitors,
            'visitors' => $visitors->lastVisitors(),
            'chart' => $visitors->chart(),
        ]);
    }
}
