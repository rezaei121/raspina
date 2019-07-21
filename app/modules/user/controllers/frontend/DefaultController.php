<?php

namespace app\modules\user\controllers\frontend;

use app\modules\user\models\User;
use yii\web\NotFoundHttpException;

/**
 * DefaultController implements the CRUD actions for User model.
 */
class DefaultController extends \app\components\Controller
{
    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionAbout($username = null)
    {
        return $this->render('@theme/about.twig', [
            'model' => ($username !== null)? [$this->findByUsernameModel($username)] : User::find()->where(['status' => User::STATUS_ACTIVE])->all(),
        ]);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findByUsernameModel($username)
    {
        if (($model = User::findOne(['username' => $username])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
