<?php
use backend\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use dosamigos\tinymce\TinyMce;
use backend\modules\post\models\Category;
use backend\modules\post\models\PostCategory;

/* @var $this yii\web\View */
/* @var $model backend\modules\post\models\Post */
?>

<?= Html::beginPanel($this->title) ?>
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'auto_save')->checkbox(); ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'Title')])->label(false) ?>
    <?= Select2::widget([
        'name' => 'post_categories',
        'id' => 'post-post_categories',
        'value' => PostCategory::getSelectedCategories($model->id),
        'class' => 'form-control',
        'data' => Category::getAll(),
        'options' => ['multiple' => true, 'placeholder' => Yii::t('app', 'Categories')],
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
    ])->label(false) ?>

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
        ])->label(false) ?>
    </div>
    <?php
        $tags = $model->convertToAssociativeArray($model->tags);
        echo Select2::widget([
            'name' => 'tags',
            'id' => 'post_tags',
            'value' => $tags,
            'class' => 'form-control',
            'data' => $tags,
            'options' => ['multiple' => true, 'placeholder' => Yii::t('app', 'Tags')],
            'pluginOptions' => [
                'tags' => true,
                'maximumInputLength' => 100
            ],
        ]);
    ?>
    <?php
        $keywords = $model->convertToAssociativeArray($model->keywords);
        echo Select2::widget([
            'name' => 'keywords',
            'id' => 'post_keywords',
            'value' => $keywords,
            'class' => 'form-control',
            'data' => $keywords,
            'options' => ['multiple' => true, 'placeholder' => Yii::t('app', 'Keywords')],
            'pluginOptions' => [
                'tags' => true,
                'tokenSeparators' => [','],
                'maximumInputLength' => 100
            ],
        ]);
    ?>
    <?= $form->field($model, 'meta_description')->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'Meta Description')])->label(false) ?>
    <?= $form->field($model, 'status')->dropDownList($model->postStatus(), ['placeholder' => Yii::t('app', 'Status')])->label(false) ?>

    <?php
        $createdAt = !empty($model->created_at) ? new \DateTime($model->created_at) : null;
    ?>
    <div id="post-date-section" class="display-none">
        <div style="width:50px; float: right;">
            <?= $form->field($model, 'minute')->textInput(['value'=>($createdAt !== null) ? $createdAt->format('i') : '59','class'=>'form-control center-text','maxlength' => true]) ?>
        </div>
        <div style="width:50px; float: right; margin-right:5px">
            <?= $form->field($model, 'hour')->textInput(['value'=>!empty($createdAt !== null) ? $createdAt->format('H') : '23','class'=>'form-control center-text','maxlength' => true]) ?>
        </div>
        <div style="float: right;margin-right:5px">
            <?= $form->field($model, 'date')->textInput(['value' =>  !empty($createdAt !== null) ? Yii::$app->date->asDate($createdAt) : Yii::$app->date->asDate('now', 'php:Y-m-d'), 'class' => 'form-control center-text', 'maxlength' => true]) ?>
        </div>
    </div>

    <?= $form->field($model, 'post_id')->hiddenInput()->label(false); ?>
    <div class="clear"></div>
    <?= $form->field($model, 'enable_comments')->checkbox(); ?>
    <?= $form->field($model, 'pin_post')->checkbox(); ?>
    <div class="form-group center-text">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
<?= Html::endPanel() ?>