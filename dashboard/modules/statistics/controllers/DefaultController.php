<?php

namespace dashboard\modules\statistics\controllers;


use common\models\Visitors;
use dashboard\modules\statistics\models\Statistics;
use yii\web\Controller;

/**
 * Default controller for the `statistics` module
 */
class DefaultController extends Controller
{
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
