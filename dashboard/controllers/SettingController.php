<?php
namespace dashboard\controllers;

use Yii;
use dashboard\models\Setting;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SettingController implements the CRUD actions for Setting model.
 */
class SettingController extends Controller
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
                        'roles' => ['@'],
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
        $model->getTemplatesName();

        $model = $model->find()->one();

        $request = Yii::$app->request->post();
        if ($model->load(Yii::$app->request->post()))
        {
            if(isset($request['keyword']))
            {
                $keywords = explode(',',$model->keyword);
                $model->keyword = \dashboard\modules\post\models\Post::setSelect2Value($request['keyword'],$keywords);
            }

            $url_len = mb_strlen($model->url) - 1;
            if($model->url[$url_len] != '/')
            {
                $model->url .= '/';
            }

            if($model->save())
            {
                Yii::$app->session->setFlash('success', Yii::t('app','Changes Successfully Applied'));
            }
            else
            {
                Yii::$app->session->setFlash('error', Yii::t('app','Operation Failed'));
            }
        }

        $model->keyword = explode(',',$model->keyword);
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
