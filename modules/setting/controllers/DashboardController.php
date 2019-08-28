<?php

namespace app\modules\setting\controllers;

use app\components\helpers\MysqlBackup;
use Yii;
use app\modules\setting\models\Setting;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for Setting model.
 */
class DashboardController extends \app\components\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['update', 'backup'],
                'rules' => [
                    [
                        'actions' => ['update', 'backup'],
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

    public function actionBackup()
    {
        $sql = new MysqlBackup();
        $tables = $sql->getTables();
        if (!$sql->StartBackup()) {
            //render error
            die;
        }
        foreach ($tables as $tableName) {
            $sql->getColumns($tableName);
        }
        foreach ($tables as $tableName) {
            $sql->getData($tableName);
        }
        $sqlFile = $sql->EndBackup();

        $file_path = $sqlFile;
        header('Content-Description: File Transfer');
        header("Content-Type: application/sql");
        header('Content-Disposition: inline; filename=backup_'. date("Y-m-d H-i-s"). '.sql');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_path));
        readfile($file_path);
        unlink($file_path);
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
