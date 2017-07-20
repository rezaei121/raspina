<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model dashboard\models\Setting */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading"><?= $this->title ?></div>
        <div class="panel-body">

<div class="setting-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true,'dir'=>'ltr']) ?>

    <?= $form->field($model, 'template')->dropDownList($model->getTemplatesName()) ?>
    
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= Select2::widget([
        'name' => 'keyword',
        'value' => !empty($model->keyword[0]) ? array_keys($model->keyword) : [],
        'class' => 'form-control',
        'data' => !empty($model->keyword[0]) ? $model->keyword : [],
        'options' => ['multiple' => true, 'placeholder' => Yii::t('app', 'Insert Keywords')],
        'pluginOptions' => [
            'tags' => true,
            'maximumInputLength' => 100
        ],
    ]); ?>

    <?= $form->field($model, 'page_size')->textInput(['dir'=>'ltr']) ?>

    <?= $form->field($model, 'date_format')->textInput(['maxlength' => true,'dir'=>'ltr']) ?>

    <?= $form->field($model, 'activation_newsletter')->checkbox(); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

        </div>
    </div>
</div>
