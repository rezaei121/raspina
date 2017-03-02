<?php
namespace frontend\controllers;
use frontend\models\About;
use Yii;

class AboutController extends BaseController
{
    public function actions()
    {
        $this->layout = $this->setting['layout'];
    }

    public function actionIndex()
    {
        $model = new About();
        return $this->render('about',[
            'about' => $model->get()
        ]);
    }

}
