<?php
namespace dashboard\modules\about\controllers;

use Yii;
use dashboard\modules\about\models\About;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use yii\helpers\Url;

/**
 * Default controller for the `about` module
 */
class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','delete'],
                'rules' => [
                    [
                        'actions' => ['index','delete'],
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

    public function actions()
    {
        return [
            'avatar' => [
                'class' => 'developit\jcrop\actions\Upload',
                'url' => Url::home() . '../../common/files/avatar/',
                'path' => Yii::getAlias('@user_avatar'),
                'name' => Yii::$app->hashids->encode(Yii::$app->user->id)
            ]
        ];
    }

    public function actionIndex()
    {
        $user_id = Yii::$app->user->id;
        $model = About::find()->where(['user_id' => $user_id])->one();
        if(empty($model))
        {
            $model = new About();
            $model->user_id = $user_id;
            $model->save();
        }

        $model->user_id = $user_id;
        if ($model->load(Yii::$app->request->post()))
        {
            if($model->save())
            {
                Yii::$app->session->setFlash('success', Yii::t('app','Changes Successfully Applied'));
            }
            else
            {
                Yii::$app->session->setFlash('error', Yii::t('app','Operation Failed'));
            }
        }

        $model = About::find()->where(['user_id' => $user_id])->one();
        
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing About model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        unlink(Yii::getAlias('@user_avatar') . '/' . $model->avatar);
        $model->avatar = NULL;
        $model->save();

        return $this->redirect(['index']);
    }

    /**
     * Finds the About model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return About the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = About::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
