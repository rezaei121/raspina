<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use app\components\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Request password reset';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-request-password-reset">
    <div class="row">
        <div class="col-lg-12">
            <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

            <?= $form->field($model, 'email')->textInput(['placeholder' => Yii::t('app','Email')]) ?>
            <?= Html::submitButton(Yii::t('app','Send'), ['class' => 'btn btn-success btn-login']) ?>
            <div class="center login-forget">
                <?= Html::a(Yii::t('app','Login page'), ['login']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
