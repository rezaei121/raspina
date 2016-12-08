<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use dosamigos\tinymce\TinyMce;
use mrlco\datepicker\Datepicker;
?>

<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading"><?= $this->title ?></div>
        <div class="panel-body">

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= Select2::widget([
        'name' => 'post_categories',
        'id' => 'post-post_categories',
        'value' => $model->getSelectedCategories(),
        'class' => 'form-control',
        'data' => $model->getAllCategories(),
        'options' => ['multiple' => true, 'placeholder' => Yii::t('app', 'Select Category')],
        'pluginOptions' => [
            'tags' => true,
            'maximumInputLength' => 255
        ],
    ]); ?>

    <?= $form->field($model, 'short_text')->widget(TinyMce::className(), [
        'options' => ['rows' => 12],
        'language' => 'fa',
        'clientOptions' => [
            'directionality' => "rtl",
            'entity_encoding' => "utf-8",
            'relative_urls' => false,
            'plugins' => [
                "advlist autolink lists link charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste link image"
            ],

            'toolbar' => "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
        ]
    ]);?>

    <?= $form->field($model, 'more_text')->widget(TinyMce::className(), [
        'options' => ['rows' => 12],
        'language' => 'fa',
        'clientOptions' => [
            'directionality' => "rtl",
            'relative_urls' => false,
            'entity_encoding' => "utf-8",
            'plugins' => [
                "advlist autolink lists link charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste link image codesample"
            ],

            'toolbar' => "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | codesample"
        ]
    ]);?>

    <?= Select2::widget([
        'name' => 'tags',
        'id' => 'post_tags',
        'value' => !empty($model->tags[0]) ? array_keys($model->tags) : [],
        'class' => 'form-control',
        'data' => !empty($model->tags[0]) ? $model->tags : [],
        'options' => ['multiple' => true, 'placeholder' => Yii::t('app', 'Insert Tags')],
        'pluginOptions' => [
            'tags' => true,
            'maximumInputLength' => 100
        ],
    ]); ?>

    <?= Select2::widget([
        'name' => 'keywords',
        'id' => 'post_keywords',
        'value' => !empty($model->keywords[0]) ? array_keys($model->keywords) : [],
        'class' => 'form-control',
        'data' => !empty($model->keywords[0]) ? $model->keywords : [],
        'options' => ['multiple' => true, 'placeholder' => Yii::t('app', 'Insert Keywords')],
        'pluginOptions' => [
            'tags' => true,
            'maximumInputLength' => 100
        ],
    ]); ?>

    <?= $form->field($model, 'meta_description')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'status')->dropDownList($model->postStatus()) ?>

    <?= '<div class="display-none" id="status_2_datepicker">' ?>
        <?= '<div class="" style="width:50px; float: right;">' . $form->field($model, 'minute')->textInput(['value'=>!empty($model->create_time) ? date('i',$model->create_time) : '59','class'=>'form-control center-text','maxlength' => true]) . '</div>' ?>
        <?= '<div class="" style="float: right; margin: 18px 5px 0px 5px; font-size: 24px;">:</div>' ?>
        <?= '<div class="" style="width:50px; float: right">' . $form->field($model, 'hour')->textInput(['value'=>!empty($model->create_time) ? date('H',$model->create_time) : '23','class'=>'form-control center-text','maxlength' => true]) . '</div>' ?>

        <?= '<div class="" style="float: right;margin-right:5px">' . $form->field($model, 'date')->widget(
            Datepicker::className(), [
            'inline' => true,
            'value' => !empty($model->create_time) ? date('Y/m/d',$model->create_time) : '',
            'template' => '<div class="" style="background-color: #fff; width:100px">{input}</div>',
            'clientOptions' => [
                'format' => 'YYYY/MM/DD'
            ]
        ]) . '</div>' ?>
    <?= '</div>' ?>

    <?= $form->field($model, 'post_id')->hiddenInput()->label(false); ?>
    <div class="clear"></div>
    <?= $form->field($model, 'comment_active')->checkbox(); ?>
    <?= $form->field($model, 'pin_post')->checkbox(); ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create Post') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>
    <?php ActiveForm::end(); ?>
</div>

        </div>
    </div>
</div>