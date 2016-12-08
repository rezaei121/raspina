<?php

namespace backend\controllers;
use Yii;
use common\models\User;

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
            $model->save();
            Yii::$app->session->setFlash('success', Yii::t('app','Saved User Account'));
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
    
}
