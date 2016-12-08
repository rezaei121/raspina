<?php

namespace frontend\controllers;
use Yii;

class ContactController extends BaseController
{
    public function actions()
    {
        $this->layout = $this->setting['layout'];
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    public function actionIndex()
    {
        $contact = new \backend\models\Contact;

        $contact->create_time = time();
        $contact->ip = $_SERVER['REMOTE_ADDR'];

        $request = Yii::$app->request->post();
        if($contact->load($request) && $contact->save())
        {
            Yii::$app->getSession()->setFlash('success', Yii::t('app','Contact Successfully Sent'));
        }

        Yii::$app->view->title = Yii::t('app','Contact Me');
        return $this->render('contact',[
            'contact' => $contact
        ]);
    }

}
