<?php

use dashboard\components\widgets\ActiveForm;
use yii\helpers\Html;
use developit\captcha\Captcha;

$this->title = Yii::t('app', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">

    <div class="row">
        <div class="col-lg-12">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <?= $form->field($model, 'username')->textInput() ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model,'captcha')->widget(Captcha::className(),[
                 'captchaAction' => '/site/login-captcha', 'options' => ['class' => 'form-control captcha'],
                'template' => '<div class="captcha-img">{image}</div><div class="captcha-txt">{input}</div>'
            ]) ?>

            <?= $form->field($model, 'rememberMe')->checkbox() ?>

            <?= Html::submitButton(Yii::t('app', 'Login'), ['class' => 'btn btn-success btn-login', 'name' => 'login-button']) ?>
            <div class="center login-forget">
                <?= Html::a(Yii::t('app', 'Forgot password?'), ['request-password-reset']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
