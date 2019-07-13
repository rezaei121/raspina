<?php

namespace app\modules\statistics\controllers\dashboard;

use app\modules\statistics\models\Statistics;
use app\modules\statistics\models\Visitors;
use yii\filters\AccessControl;

/**
 * Default controller for the `statistics` module
 */
class DefaultController extends \app\components\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index','update','delete'],
                        'allow' => true,
                        'roles' => ['author', 'moderator', 'admin'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $model = new Statistics;
        $visitors = new Visitors();

        return $this->render('index', [
            'model' => $model,
            'pie_chart' => $visitors->pie_chart(),
            'visit_period' => $visitors->visit_period(),
        ]);
    }
}
