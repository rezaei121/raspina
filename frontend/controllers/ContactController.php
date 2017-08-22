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
        $contact = new \frontend\models\Contact;
        $contact->ip = $_SERVER['REMOTE_ADDR'];

        $request = Yii::$app->request->post();
        if($contact->load($request) && $contact->save())
        {
            Yii::$app->getSession()->setFlash('success', Yii::t('app','Contact Successfully Sent'));
        }

        return $this->render('contact',[
            'contact' => $contact
        ]);
    }

}
