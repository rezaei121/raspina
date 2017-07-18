<?php
use backend\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model backend\modules\file\models\File */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<?= $form->field($model, 'myfile[]')->widget(FileInput::classname(), [
    'options' => ['accept' => '', 'multiple' => true, 'placeholder' => Yii::t('app', 'File')],
    'pluginOptions' => [
        'initialCaption' => '',
        'showPreview' => false,
        'showCaption' => true,
        'showRemove' => true,
        'showUpload' => false
    ]
])->label(false); ?>
<div class="align-center">
    <?= Html::submitButton(Yii::t('app', 'Upload'), ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>
