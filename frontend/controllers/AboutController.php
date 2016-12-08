<?php

namespace frontend\controllers;
use Yii;

class AboutController extends BaseController
{
    public function actions()
    {
        $this->layout = $this->setting['layout'];
    }

    public function actionIndex()
    {
        $query = new \yii\db\Query();
        $about = $query->select('*')->from(\backend\models\About::tableName())->one();
        Yii::$app->view->title = Yii::t('app','About Me');
        return $this->render('about',[
            'about' => $about
        ]);
    }

}
