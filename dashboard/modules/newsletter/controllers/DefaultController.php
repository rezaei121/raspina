<?php

namespace dashboard\modules\newsletter\controllers;

use dashboard\modules\newsletter\models\NewsletterLog;
use Yii;
use dashboard\modules\newsletter\models\Newsletter;
use dashboard\modules\newsletter\models\NewsletterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;


/**
 * NewsletterController implements the CRUD actions for Newsletter model.
 */
class DefaultController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','send','logs','template','delete', 'get-default-template'],
                'rules' => [
                    [
                        'actions' => ['index','send','logs','template','delete', 'get-default-template'],
                        'allow' => true,
                        'roles' => ['moderator', 'admin'],
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
     * Lists all Newsletter models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NewsletterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'userCount' => NewsletterSearch::find()->count(),
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Newsletterlog models.
     * @return mixed
     */
    public function actionLogs()
    {
        $model = new NewsletterLog();
        $query = NewsletterLog::find();
        $pageSize = \Yii::$app->setting->pageSize();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]],
            'pagination' => ['pageSize' => $pageSize]
        ]);

        return $this->render('logs', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Newsletterlog models.
     * @return mixed
     */
    public function actionTemplate()
    {
        $model = new Newsletter();
        $filePath = Yii::getAlias('@common') . '/mail/layouts/newsletter.php';

        $request = Yii::$app->request->post();
        if(isset($request['Newsletter']['template']))
        {
            file_put_contents($filePath,$request['Newsletter']['template']);
            Yii::$app->session->setFlash('success', Yii::t('app','{object} saved.',[
                'object' => Yii::t('app','Template')
            ]));
        }

        $model->template = file_get_contents($filePath);
        return $this->render('template', [
            'model' => $model,
        ]);
    }

    /**
     * Lists all Newsletterlog models.
     * @return mixed
     */
    public function actionGetDefaultTemplate()
    {
        $filePath = Yii::getAlias('@common') . '/mail/layouts/default_newsletter_template.php';
        return file_get_contents($filePath);
    }

    /**
     * Creates a new Newsletter model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionSend()
    {
        $model = new Newsletter();
        $request = Yii::$app->request->post();
        if ($model->load($request))
        {
            $compose = $model->send($request['emails']);
            if($compose)
            {
                // save newsletter Log
                $logModel = new NewsletterLog();
                $logModel->title = $model->title;
                $logModel->text = $model->text;
                $logModel->user_id = Yii::$app->user->id;
                $logModel->save();

                Yii::$app->getSession()->setFlash('success',Yii::t('app','Your Newsletter has been sent.'));
            }
            else
            {
                Yii::$app->getSession()->setFlash('error',Yii::t('app','Your Newsletter has been not sent.'));
            }

            return $this->redirect(['logs',]);
        }

        return $this->render('send', [
            'model' => $model,
        ]);
    }
    /**
     * Deletes an existing Newsletter model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', Yii::t('app','{object} deleted.',[
            'object' => Yii::t('app','Email')
        ]));
        return $this->redirect(['index']);
    }

    /**
     * Finds the Newsletter model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Newsletter the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Newsletter::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGroupActions()
    {
        $action = Yii::$app->request->post('action');
        $selection=(array)Yii::$app->request->post('selection');

        if(empty($selection))
        {
            Yii::$app->session->setFlash('warning', Yii::t('app','No item selected.'));
            return $this->redirect(['index']);
        }

        if($action == 'delete')
        {
            Newsletter::deleteAll(['id'=>$selection]);
            Yii::$app->session->setFlash('success', Yii::t('app','Emails deleted.'));
        }

        return $this->redirect(['index']);
    }
}
