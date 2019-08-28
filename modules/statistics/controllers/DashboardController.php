<?php

namespace app\modules\statistics\controllers;

use app\modules\statistics\models\Statistics;
use app\modules\statistics\models\Visitor;
use yii\filters\AccessControl;

/**
 * Default controller for the `statistics` module
 */
class DashboardController extends \app\components\Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['index'],
            'rules' => [
                [
                    'actions' => ['index','update','delete', 'home'],
                    'allow' => true,
                    'roles' => ['author', 'moderator', 'admin'],
                ],
            ],
        ];
        return $behaviors;
    }

    public function actionHome()
    {
        $visitors = new Visitor;
        return $this->render('home',[
            'visitorsModel' => $visitors,
            'visitors' => $visitors->lastVisitors(),
            'chart' => $visitors->chart(),
        ]);
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $model = new Statistics;
        $visitors = new Visitor();

        return $this->render('index', [
            'model' => $model,
            'pie_chart' => $visitors->pie_chart(),
            'visit_period' => $visitors->visit_period(),
        ]);
    }
}
