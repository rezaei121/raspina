<?php
namespace app\modules\contact\controllers;

use app\components\Controller;
use app\modules\contact\models\Contact;
use app\modules\post\models\Comment;
use app\modules\statistics\models\Visitor;
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
    }

    public function actionIndex()
    {
        $contact = new Contact();
        $contact->ip = $_SERVER['REMOTE_ADDR'];

        $request = Yii::$app->request->post();
        if($contact->load($request))
        {
            if(Visitor::isValid())
            {
                if($contact->save())
                {
                    Yii::$app->getSession()->setFlash('success', Yii::t('app','Contact successfully sent'));
                }
            }
            else
            {
                Yii::$app->getSession()->setFlash('warning', Yii::t('app','You are not a valid user and cannot send!'));
            }
        }

        $contact = new Contact;
        return $this->render('@theme/contact.twig',[
            'model' => $contact
        ]);
    }
}
