<?php

namespace dashboard\modules\user\controllers;

use dashboard\modules\file\models\File;
use dashboard\modules\post\models\Comment;
use dashboard\modules\post\models\Post;
use dashboard\modules\user\models\AuthAssignment;
use dashboard\modules\user\models\LoginForm;
use Yii;
use dashboard\modules\user\models\User;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for User model.
 */
class DefaultController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'create', 'update', 'delete', 'view'],
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'delete', 'view'],
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


    public function actions()
    {
        return [
            'myavatar' => [
                'class' => 'developit\jcrop\actions\Upload',
                'url' => Url::home() . '../common/files/avatar/',
                'path' => Yii::getAlias('@user_avatar'),
                'name' => Yii::$app->hashids->encode(Yii::$app->user->id),
            ]
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]]
        ]);
    }

    public function actionAvatar()
    {
        $model = new User;
        return $this->render('avatar', [
            'model' => $model
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $pageSize = \Yii::$app->setting->pageSize();

        $postQuery = Post::find();
        $postDataProvider = new ActiveDataProvider([
            'query' => $postQuery,
            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]],
            'pagination' => ['pageSize' => $pageSize, 'pageParam' => 'p1', 'pageSizeParam' => 'p1-size']
        ]);

        $fileQuery = File::find();
        $fileDataProvider = new ActiveDataProvider([
            'query' => $fileQuery,
            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]],
            'pagination' => ['pageSize' => $pageSize, 'pageParam' => 'p2', 'pageSizeParam' => 'p2-size']
        ]);

        $commentQuery = Comment::find()
            ->select(['comment.*', 'post.title'])
            ->alias('comment')
            ->innerJoin(['post' => Post::tableName()], 'comment.post_id = post.id')
            ->where(['or',
            ['comment.created_by' => $id],
            ['comment.updated_by' => $id],
        ]);

        $commentDataProvider = new ActiveDataProvider([
            'query' => $commentQuery,
            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]],
            'pagination' => ['pageSize' => $pageSize, 'pageParam' => 'p3', 'pageSizeParam' => 'p3-size']
        ]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'postDataProvider' => $postDataProvider,
            'fileDataProvider' => $fileDataProvider,
            'commentDataProvider' => $commentDataProvider,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        $model->scenario = 'create';
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->setPassword($model->password);
            $model->generateAuthKey();
            if($model->save())
            {
                $assignmentModel = new AuthAssignment;
                $assignmentModel->item_name = $model->role;
                $assignmentModel->user_id = $model->id;
                $assignmentModel->save();
            }

            Yii::$app->session->setFlash('success', Yii::t('app','{object} created.',[
                'object' => Yii::t('app','User')
            ]));
            return $this->redirect(['view', 'id' => $model->id]);

        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'update';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('app','{object} updated.',[
                'object' => Yii::t('app','User')
            ]));
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing passwoird User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdatePassword($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'update-password';
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->setPassword($model->password);
            $model->generateAuthKey();
            $model->save();

            Yii::$app->session->setFlash('success', Yii::t('app','{object} updated.',[
                'object' => Yii::t('app','Password')
            ]));
            return $this->redirect(['view', 'id' => $model->id]);

        } else {
            return $this->render('update-password', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = 0;
        $model->save();

        Yii::$app->session->setFlash('success', Yii::t('app','{object} disabled.',[
            'object' => Yii::t('app','User')
        ]));

        return $this->redirect(['index']);
    }

    public function actionLogin()
    {
        $this->layout = 'login';
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        $model->scenario = 'user-login';
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $visitor = new\common\models\Visitors;
            $visitor->delete();

            return $this->goHome();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
