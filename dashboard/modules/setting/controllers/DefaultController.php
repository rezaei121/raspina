<?php

namespace dashboard\modules\setting\controllers;

use Yii;
use dashboard\modules\setting\models\Setting;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for Setting model.
 */
class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['update'],
                'rules' => [
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Updates an existing Setting model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $model = new Setting;
        $model = $model->find()->one();

        $request = Yii::$app->request->post();
        if ($model->load(Yii::$app->request->post()))
        {
            $model->keyword = (isset($request['keyword']) && !empty($request['keyword'])) ? implode(',', $request['keyword']) : null;

            $url_len = mb_strlen($model->url) - 1;
            if($model->url[$url_len] != '/')
            {
                $model->url .= '/';
            }

            $model->direction = $model->getLanguageDir($model->language);

            if($model->save())
            {
                Yii::$app->session->setFlash('success', Yii::t('app','{object} updated.',[
                    'object' => Yii::t('app','Settings')
                ]));
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Setting model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Setting the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Setting::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
