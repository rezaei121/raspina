<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\helpers\Html;
use dashboard\components\widgets\ActiveForm;

$this->title = 'Reset password';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-reset-password">

    <div class="row">
        <div class="col-lg-12">
            <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

                <?= $form->field($model, 'password')->passwordInput(['placeholder' => Yii::t('app','Password')])->label(false) ?>

                <?= Html::submitButton(Yii::t('app','Save'), ['class' => 'btn btn-login btn-success']) ?>
                <hr>
            <div class="center login-forget">
                <?= Html::a(Yii::t('app','Login page'), ['login']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
