<?php
use dashboard\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use dosamigos\tinymce\TinyMce;
use developit\jcrop\Jcrop;

/* @var $this yii\web\View */
/* @var $model dashboard\modules\about\models\About */
/* @var $form yii\widgets\ActiveForm */
?>
<?= Html::beginPanel($this->title) ?>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?php echo $form->field($model, 'avatar')->widget(Jcrop::className(), [
        'uploadUrl' => Url::toRoute('/about/default/avatar'),
        'width' => 400,
        'height' => 400
    ]) ?>
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
<?= Html::endPanel() ?>