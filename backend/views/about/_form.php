<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use dosamigos\tinymce\TinyMce;

/* @var $this yii\web\View */
/* @var $model backend\models\About */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading"><?= $this->title ?></div>
        <div class="panel-body">

<div class="about-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?php
        if(!empty($model->avatar))
        {
            echo Html::a(Yii::t('app', 'Remove Current Image'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'style' => 'float:left; margin:22px 10px 0px 0px; padding: 8px 8px 9px 8px;',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]);
        }
    ?>

    <?php
        echo $form->field($model, 'avatar')->widget(FileInput::classname(), [
        'options' => ['accept' => 'image/*'],
        'pluginOptions' => [
            'initialCaption'=> $model->avatar,
            'showPreview' => false,
            'showCaption' => true,
            'showRemove' => true,
            'showUpload' => false
        ]
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true,'class' => 'form-control']) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true,'class' => 'form-control input-ltr-dir']) ?>

    <?= $form->field($model, 'short_text')->widget(TinyMce::className(), [
        'options' => ['rows' => 6],
        'language' => 'fa',
        'clientOptions' => [
            'directionality' => "rtl",
            'relative_urls' => false,
            'entity_encoding' => "utf-8",
            'plugins' => [
                "advlist autolink lists link charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste link image"
            ],

            'toolbar' => "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
        ]
    ]);?>

    <?= $form->field($model, 'more_text')->widget(TinyMce::className(), [
        'options' => ['rows' => 6],
        'language' => 'fa',
        'clientOptions' => [
            'directionality' => "rtl",
            'plugins' => [
                "advlist autolink lists link charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste codesample link image"
            ],

            'toolbar' => "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | codesample"
        ]
    ]);?>

    <?= $form->field($model, 'facebook')->textInput(['maxlength' => true,'class' => 'form-control input-ltr-dir']) ?>
    <?= $form->field($model, 'twitter')->textInput(['maxlength' => true,'class' => 'form-control input-ltr-dir']) ?>
    <?= $form->field($model, 'googleplus')->textInput(['maxlength' => true,'class' => 'form-control input-ltr-dir']) ?>
    <?= $form->field($model, 'instagram')->textInput(['maxlength' => true,'class' => 'form-control input-ltr-dir']) ?>
    <?= $form->field($model, 'linkedin')->textInput(['maxlength' => true,'class' => 'form-control input-ltr-dir']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Update') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
        </div>
    </div>
</div>
