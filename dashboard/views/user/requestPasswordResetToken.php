<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Request password reset';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-request-password-reset">
    <div class="row">
        <div class="col-lg-12">
            <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

            <?= $form->field($model, 'email')->textInput(['placeholder' => Yii::t('app','Email')])->label(false) ?>
            <?= Html::submitButton(Yii::t('app','Send'), ['class' => 'btn btn-login']) ?>
            <hr>
            <?= Html::a(Yii::t('app','Login Page'), ['user/login']) ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
