<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use developit\captcha\Captcha;
use frontend\components\helpers\Raspina;

Raspina::title('Contact Me');
?>
<div class="post-border shadow">
    <div class="panel panel-default post-panel">
        <div class="panel-body">
            <div class="post-title"><?= Raspina::t('Contact Me') ?></div>
            <div class="post-text">
                <!-- -->
                <?php $form = ActiveForm::begin() ?>
                <?= $form->field($model,'name')->textInput(['maxlength' => true,'class' => 'input margin-17','placeholder' => Raspina::t('Name')]) ?>
                <?= $form->field($model,'email')->textInput(['maxlength' => true,'class' => 'input margin-17','placeholder' => Raspina::t('Email'),'dir' => 'ltr']) ?>
                <?= $form->field($model,'site')->textInput(['maxlength' => true,'class' => 'input margin-17','placeholder' => Raspina::t('Site'),'dir' => 'ltr']) ?>
                <?= $form->field($model,'message')->textArea(['rows' => '6' ,'class' => 'input margin-17','placeholder' => Raspina::t('Message')]) ?>
                <?= $form->field($model,'captcha')->widget(Captcha::className(),['options' => ['placeholder' => Raspina::t('Captcha')]]) ?>
                <?= Html::submitButton('ارسال پیام',['class' => 'submit']) ?>
                <?php ActiveForm::end() ?>
                <!-- -->
            </div>
        </div>
    </div>
</div>