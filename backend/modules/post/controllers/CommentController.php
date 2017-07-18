<?php
namespace backend\modules\post\controllers;

use Yii;
use backend\modules\post\models\Comment;
use backend\modules\post\models\CommentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * CommentController implements the CRUD actions for Comment model.
 */
class CommentController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','view','delete','create','bulk'],
                'rules' => [
                    [
                        'actions' => ['index','view','delete','create','group-actions'],
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
     * Lists all Comment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Comment();
        $searchModel = new CommentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }

    /**
     * Displays a single Comment model.
     * @param string $id
     * @return mixed
     */
    public function actionApprove($id)
    {
        $model = $this->findModel($id);
        $model->status = 1;
        var_dump($model->save());
        if($model->save())
        {
            Yii::$app->session->setFlash('success', Yii::t('app','{object} approved.',[
                'object' => Yii::t('app','Comment')
            ]));
        }
        return $this->redirect(['comment/view', 'id' => $id]);
    }

    /**
     * Displays a single Comment model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        $model->scenario = 'reply';
        if ($model->load(Yii::$app->request->post())) {
            $model->status = 1;
            if($model->save())
            {
                Yii::$app->session->setFlash('success', Yii::t('app','Reply saved.'));
            }
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Comment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', Yii::t('app','{object} deleted.',[
            'object' => Yii::t('app','Comment')
        ]));
        return $this->redirect(['index']);
    }

    public function actionGroupActions()
    {
        $GETrequest = Yii::$app->request->get();
        $selection = isset($GETrequest['id'])? (array)$GETrequest['id'] : (array)Yii::$app->request->post('selection');
        $action = isset($GETrequest['action'])? $GETrequest['action'] : Yii::$app->request->post('action');


        if(empty($selection))
        {
            Yii::$app->session->setFlash('warning', Yii::t('app','No item selected.'));
            return $this->redirect(['index']);
        }

        if($action == 'approve')
        {
            Comment::updateAll(['status' => 1],['id'=>$selection]);
            Yii::$app->session->setFlash('success', Yii::t('app','Comments approved.'));
        }

        if($action == 'delete')
        {
            Comment::deleteAll(['id'=>$selection]);
            Yii::$app->session->setFlash('error', Yii::t('app','Comments deleted.'));
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Comment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Comment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Comment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
