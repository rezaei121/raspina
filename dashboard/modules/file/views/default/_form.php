<?php
use dashboard\components\helpers\Html;
use dashboard\components\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model dashboard\modules\file\models\File */
/* @var $form dashboard\components\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<?= $form->field($model, 'myfile[]')->widget(FileInput::classname(), [
    'options' => ['accept' => '', 'multiple' => true],
    'language' =>  Yii::$app->params['lang'],
    'pluginOptions' => [
        'initialCaption' => '',
        'showPreview' => false,
        'showCaption' => true,
        'showRemove' => true,
        'showUpload' => false
    ]
])?>
<div class="center">
    <?= Html::submitButton(Yii::t('app', 'Upload'), ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>
