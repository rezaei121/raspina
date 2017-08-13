<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use developit\captcha\Captcha;
use frontend\helpers\Raspina;

Raspina::title(Yii::t('app','Contact Me'));
?>
<div class="post-border shadow">
    <div class="panel panel-default post-panel">
        <div class="panel-body">
            <div class="post-title"><?= Yii::t('app','Contact Me') ?></div>
            <div class="post-text">
                <!-- -->
                <?php $form = ActiveForm::begin() ?>
                <?= $form->field($contact,'name')->textInput(['maxlength' => true,'class' => 'input margin-17','placeholder' => 'نام']) ?>
                <?= $form->field($contact,'email')->textInput(['maxlength' => true,'class' => 'input margin-17','placeholder' => 'ایمیل','dir' => 'ltr']) ?>
                <?= $form->field($contact,'message')->textArea(['rows' => '6' ,'class' => 'input margin-17','placeholder' => 'متن...']) ?>
                <?= $form->field($contact,'captcha')->widget(Captcha::className(),['template' => '<div class="captcha-img">{image}</div><div class="captcha-txt">{input}</div>']) ?>
                <?= Html::submitButton('ارسال پیام',['class' => 'submit']) ?>
                <?php ActiveForm::end() ?>
                <!-- -->
            </div>
        </div>
    </div>
</div>