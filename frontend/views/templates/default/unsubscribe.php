<?php
use yii\widgets\ActiveForm ;
use yii\helpers\Html;
use developit\captcha\Captcha;
use frontend\components\helpers\Raspina;

Raspina::title(Yii::t('app', 'Unsubscribe Newsletter'));
?>
<div class="post-border shadow">
    <div class="panel panel-default post-panel">
        <div class="panel-body">
            <div class="post-title"><?= Yii::t('app', 'Unsubscribe Newsletter') ?></div>
            <div class="post-text">
                <!-- -->
                <?php $form = ActiveForm::begin() ?>
                <?= $form->field($model,'email')->textInput(['maxlength' => true,'class' => 'input margin-17','placeholder' => 'ایمیل','dir' => 'ltr'])->label(false) ?>
                <?= $form->field($model,'captcha')->widget(Captcha::className(),['options' => ['class' => 'input margin-17 captcha-txt','placeholder' => 'کد تایید، تصویر بالا را وارد کنید'], 'template' => '<div class="captcha-img">{image}</div>{input}'])->label(false) ?>
                <?= Html::submitButton('لغو عضویت',['class' => 'submit']) ?>
                <?php ActiveForm::end() ?>
                <!-- -->
            </div>
        </div>
    </div>
</div>