<?php
namespace app\modules\file\controllers\dashboard;

use app\modules\file\models\File;
use app\modules\file\models\FileSearch;
use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;

/**
 * Default controller for the `file` module
 */
class DefaultController extends \app\components\Controller
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

    /**
     * Lists all File models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FileSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new File();

        if (Yii::$app->request->isPost) {
            $model->myfile = UploadedFile::getInstances($model, 'myfile');
            $result = $model->upload();
            if($result)
            {
                Yii::$app->session->setFlash('success', Yii::t('app','File uploaded.'));
            }
        }

        return $this->render('index', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'filesInfo' => $model->filesInfo(),
            'url' => Yii::$app->setting->getValue('url')
        ]);
    }

    /**
     * Deletes an existing File model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if(RASPINA_ENV != 'demo')
        {
            unlink(Yii::getAlias('@file_upload') . '/' . $model->real_name . '.' . $model->extension);
        }
        $model->delete();
        Yii::$app->session->setFlash('success', Yii::t('app','{object} deleted.',[
            'object' => Yii::t('app','File')
        ]));
        return $this->redirect(['index']);
    }

    /**
     * Finds the File model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return File the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function findModel($id)
    {
        if (($model = File::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
