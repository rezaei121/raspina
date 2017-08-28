<?php

use common\widgets\Alert;
use dashboard\components\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

$this->title = 'DB config';
?>

<div class="centered">
    <?= Html::beginPanel($this->title) ?>
    <?= Alert::widget() ?>
    <?php Pjax::begin(); ?>
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'host')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'db_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'password')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'tb_prefix')->textInput(['maxlength' => true]) ?>
    <div class="form-group center">
        <?= Html::submitButton(Yii::t('app', 'Connetct'), ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>
    <?= Html::endPanel() ?>
</div>
