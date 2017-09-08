<?php

namespace dashboard\modules\template\controllers;

use dashboard\modules\setting\models\Setting;
use dashboard\modules\template\models\Template;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Default controller for the `template` module
 */
class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','select'],
                'rules' => [
                    [
                        'actions' => ['index','select'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ]
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
        $model = new Template;
        return $this->render('index', [
            'templates' => $model->getAllTemplates(),
            'defaultTemplate' => Yii::$app->setting->getValue('template'),
        ]);
    }

    public function actionSelect($id)
    {
        $settingModel = Setting::find()->one();
        $settingModel->template = $id;
        $settingModel->save(false);

        Yii::$app->session->setFlash('success', Yii::t('app','{object} updated.',[
            'object' => Yii::t('app','Template')
        ]));

        $this->redirect(['index']);
    }
}
