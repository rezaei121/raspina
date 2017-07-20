<?php

namespace dashboard\controllers;
use Yii;
use common\models\User;
use dashboard\models\LoginForm;

class UserController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionAccount()
    {
        $model = User::findIdentity(Yii::$app->user->id);
        $model->scenario = 'account';
        $request = Yii::$app->request->post();

        if($model->load($request) && $model->validate())
        {
            if($model->save())
            {
                Yii::$app->session->setFlash('success', Yii::t('app','Saved User Account'));
            }

        }

        return $this->render('account',[
            'model' => $model
        ]);
    }

    public function actionChangepassword()
    {
        $model = new User();
        $model->scenario = 'changepassword';
        
        if ($model->load(Yii::$app->request->post()))
        {
            if($model->new_password != $model->repeat_password)
            {
                Yii::$app->session->setFlash('error', Yii::t('app','Paswword No Mach'));
                return $this->render('changePassword',[
                    'model' => $model
                ]);
            }

            $user = User::findIdentity(Yii::$app->user->id);
            if(!$user->validatePassword($model->old_password))
            {
                Yii::$app->session->setFlash('error', Yii::t('app','Old Paswword No Mach'));
                return $this->render('changePassword',[
                    'model' => $model
                ]);
            }

            $user->setPassword($model->new_password);
            if($user->save())
            {
                Yii::$app->session->setFlash('success', Yii::t('app','New Password Was Saved'));
            }
        }

        return $this->render('changePassword',[
            'model' => $model
        ]);
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
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $this->layout = 'login';
        $model = new \dashboard\models\PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', Yii::t('app','Check Your Email'));

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app','Unable To Reset Password'));
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        $this->layout = 'login';
        try {
            $model = new \dashboard\models\ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', Yii::t('app','New Password Was Saved'));

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
