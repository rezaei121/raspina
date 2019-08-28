<?php

namespace app\modules\statistics\controllers;

use app\modules\statistics\models\Visitor;

class VisitorController extends \app\components\Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionAdd()
    {
        $data = \Yii::$app->request->post();
        if(!empty($data))
        {
            Visitor::add($data);
        }
        exit();
    }
}
