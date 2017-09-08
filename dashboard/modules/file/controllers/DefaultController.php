<?php
namespace dashboard\modules\file\controllers;

use Yii;
use dashboard\modules\file\models\File;
use dashboard\modules\file\models\FileSearch;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;

/**
 * Default controller for the `file` module
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
            $uploadFiles = $model->upload();
            if(!empty($uploadFiles))
            {
                $connection = new Query();
                $connection->createCommand()->batchInsert($model->tableName(),['name','extension','size','uploaded_by','real_name','content_type'],$uploadFiles)->execute();
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
