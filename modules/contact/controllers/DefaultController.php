<?php
namespace app\modules\contact\controllers;

use app\components\Controller;
use app\modules\contact\models\Contact;
use Yii;


/**
 * Default controller for the `contact` module
 */
class DefaultController extends Controller
{
    public function actions()
    {
        $this->module->layoutPath = Yii::$app->params['templateLayout'];
        $this->layout = 'main.twig';
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    public function actionIndex()
    {
        $contact = new Contact();
        $contact->ip = $_SERVER['REMOTE_ADDR'];

        $request = Yii::$app->request->post();
        if($contact->load($request) && $contact->save())
        {
            Yii::$app->getSession()->setFlash('success', Yii::t('app','Contact successfully sent'));
        }

        $contact = new Contact;
        return $this->render('@theme/contact.twig',[
            'model' => $contact
        ]);
    }
}
