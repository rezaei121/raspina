<?php
use backend\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model backend\modules\file\models\File */
/* @var $form yii\widgets\ActiveForm */
?>
<?= Html::beginPanel($this->title) ?>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $form->field($model, 'myfile[]')->widget(FileInput::classname(), [
            'options' => ['accept' => '','multiple' => true],
            'pluginOptions' => [
                'initialCaption'=> '',
                'showPreview' => false,
                'showCaption' => true,
                'showRemove' => true,
                'showUpload' => false
            ]
        ])->label(Yii::t('app', 'File')); ?>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Upload'), ['class' => 'btn btn-success']) ?>
        </div>
    <?php ActiveForm::end(); ?>
<?= Html::endPanel() ?>
