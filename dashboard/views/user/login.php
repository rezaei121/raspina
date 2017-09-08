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

            <?= $form->field($model, 'username')->textInput(['placeholder' => Yii::t('app','Username')])->label(false) ?>

            <?= $form->field($model, 'password')->passwordInput(['placeholder' => Yii::t('app','Password')])->label(false) ?>

            <?= $form->field($model,'captcha')->widget(Captcha::className(),['options' => ['placeholder' => Yii::t('app','Captcha'),'class' => 'form-control captcha'], 'template' => '<div class="captcha-img">{image}</div><div class="captcha-txt">{input}</div>'])->label(false) ?>

            <?= $form->field($model, 'rememberMe')->checkbox() ?>

            <?= Html::submitButton(Yii::t('app', 'Login'), ['class' => 'btn btn-login', 'name' => 'login-button']) ?>
            <hr>
            <?= Html::a(Yii::t('app', 'Forgot Password'), ['site/request-password-reset']) ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
