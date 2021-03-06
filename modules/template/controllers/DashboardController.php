<?php

namespace app\modules\template\controllers;

use app\modules\setting\models\Setting;
use app\modules\template\models\Template;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Default controller for the `template` module
 */
class DashboardController extends Controller
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
            'defaultTemplate' => Yii::$app->params['template'],
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
