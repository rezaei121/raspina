<?php
use dashboard\helpers\Html;
use dashboard\components\widgets\ActiveForm;
use kartik\select2\Select2;
use dosamigos\tinymce\TinyMce;
use dashboard\modules\post\models\Category;
use dashboard\modules\post\models\PostCategory;

/* @var $this yii\web\View */
/* @var $model dashboard\modules\post\models\Post */
?>

<?= Html::beginPanel($this->title) ?>
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'auto_save')->checkbox(); ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= Select2::widget([
        'name' => 'post_categories',
        'id' => 'post-post_categories',
        'value' => PostCategory::getSelectedCategories($model->id),
        'class' => 'form-control',
        'data' => Category::getAll(),
        'options' => ['multiple' => true],
        'pluginOptions' => [
            'tags' => true,
            'maximumInputLength' => 255
        ],
    ]); ?>
    <?= $form->field($model, 'short_text')->widget(TinyMce::className(), [
        'options' => ['rows' => 20],
        'language' => 'fa',
        'clientOptions' => [
            'directionality' => "rtl",
            'entity_encoding' => "utf-8",
            'relative_urls' => false,
            'menubar' => false,
            'automatic_uploads' => true,
            'images_upload_url' => 'postAcceptor.php',
            'images_reuse_filename' => true,
            'plugins' => [
                "advlist autolink lists link charmap visualblocks code media table contextmenu image media codesample code"
            ],
            'toolbar' => "underline italic bold styleselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | media image upload table link | code"
        ]
    ]) ?>

    <div class="post-more-section">
        <hr>
        <div class="btn btn-default post-more-btn"><?= Yii::t('app', 'More') ?></div>
    </div>

    <div id="more-text-section" class="visibility-hidden" style="500px;">
        <?= $form->field($model, 'more_text')->widget(TinyMce::className(), [
            'options' => ['rows' => 20],
            'language' => 'fa',
            'clientOptions' => [
                'directionality' => "rtl",
                'relative_urls' => false,
                'entity_encoding' => "utf-8",
                'menubar' => false,
                'plugins' => [
                    "advlist autolink lists link charmap visualblocks code media table contextmenu image media codesample code"
                ],
                'toolbar' => "underline italic bold styleselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | media image  table link | codesample | code"
            ]
        ]) ?>    <?php
        $tags = $model->convertToAssociativeArray($model->tags);
        echo Select2::widget([
            'name' => 'tags',
            'id' => 'post_tags',
            'value' => $tags,
            'class' => 'form-control',
            'data' => $tags,
            'options' => ['multiple' => true],
            'pluginOptions' => [
                'tags' => true,
                'maximumInputLength' => 100
            ],
        ]);
        ?>
    </div>

    <?php
        $keywords = $model->convertToAssociativeArray($model->keywords);
        echo Select2::widget([
            'name' => 'keywords',
            'id' => 'post_keywords',
            'value' => $keywords,
            'class' => 'form-control',
            'data' => $keywords,
            'options' => ['multiple' => true],
            'pluginOptions' => [
                'tags' => true,
                'tokenSeparators' => [','],
                'maximumInputLength' => 100
            ],
        ]);
    ?>
    <?= $form->field($model, 'meta_description')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'status')->dropDownList($model->postStatus()) ?>

    <?php
        $createdAt = !empty($model->created_at) ? new \DateTime($model->created_at) : null;
    ?>
    <div id="post-date-section" class="display-none">
        <div style="width:50px; float: right;">
            <?= $form->field($model, 'minute')->textInput(['value'=>($createdAt !== null) ? $createdAt->format('i') : '59','class'=>'form-control center','maxlength' => true]) ?>
        </div>
        <div style="width:50px; float: right; margin-right:5px">
            <?= $form->field($model, 'hour')->textInput(['value'=>!empty($createdAt !== null) ? $createdAt->format('H') : '23','class'=>'form-control center','maxlength' => true]) ?>
        </div>
        <div style="float: right;margin-right:5px">
            <?= $form->field($model, 'date')->textInput(['value' =>  !empty($createdAt !== null) ? Yii::$app->date->asDate($createdAt) : Yii::$app->date->asDate('now', 'php:Y-m-d'), 'class' => 'form-control center', 'maxlength' => true]) ?>
        </div>
    </div>

    <?= $form->field($model, 'post_id')->hiddenInput(); ?>
    <div class="clear"></div>
    <?= $form->field($model, 'enable_comments')->checkbox(); ?>
    <?= $form->field($model, 'pin_post')->checkbox(); ?>
    <div class="form-group center">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
<?= Html::endPanel() ?>