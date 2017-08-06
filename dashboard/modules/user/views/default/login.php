<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
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

            <?= $form->field($model,'captcha')->widget(Captcha::className(),['captchaAction' => '/site/captcha', 'options' => ['class' => 'form-control captcha'], 'template' => '<div class="captcha-img">{image}</div><div class="captcha-txt">{input}</div>']) ?>

            <?= $form->field($model, 'rememberMe')->checkbox() ?>

            <?= Html::submitButton(Yii::t('app', 'Login'), ['class' => 'btn btn-login', 'name' => 'login-button']) ?>
            <hr>
            <?= Html::a(Yii::t('app', 'Forgot Password'), ['site/request-password-reset']) ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
