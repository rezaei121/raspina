<?php
use dashboard\components\helpers\Html;
use dashboard\components\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;
use kartik\select2\Select2;
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
        'options' => ['multiple' => true, 'dir' => Yii::$app->params['direction'], 'placeholder' => Yii::t('app', 'Category')],
        'pluginOptions' => [
            'tags' => true,
            'maximumInputLength' => 255,
            'directionality' => Yii::$app->params['direction'],
        ],
    ]) ?>
    <?= $form->field($model, 'short_text')->widget(TinyMce::className(), [
        'options' => ['rows' => 20],
        'language' =>  Yii::$app->params['lang'],
        'clientOptions' => [
            'content_css' => \yii\helpers\Url::to(['/web/css/tinymce.css']),
            'directionality' => Yii::$app->params['direction'],
            'entity_encoding' => "utf-8",
            'relative_urls' => false,
            'menubar' => false,
            'plugins' => [
                "advlist autolink lists link charmap visualblocks code media table contextmenu image media codesample code"
            ],
            'toolbar' => "underline italic bold styleselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | media image  table link | codesample | code"
        ]
    ]) ?>

    <div class="post-more-section">
        <hr>
        <div class="btn btn-default post-more-btn"><?= Yii::t('app', 'More') ?></div>
    </div>

    <div id="more-text-section" class="visibility-hidden" style="500px;">
        <?= $form->field($model, 'more_text')->widget(TinyMce::className(), [
            'options' => ['rows' => 20, 'dir' => Yii::$app->params['direction']],
            'language' => Yii::$app->params['lang'],
            'clientOptions' => [
                'directionality' => Yii::$app->params['direction'],
                'content_css' => \yii\helpers\Url::to(['/web/css/tinymce.css']),
                'relative_urls' => false,
                'entity_encoding' => "utf-8",
                'menubar' => false,
                'plugins' => [
                    "advlist autolink lists link charmap visualblocks code media table contextmenu image media codesample code"
                ],
                'toolbar' => "underline italic bold styleselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | media image  table link | codesample | code"
            ]
        ]) ?>
    </div>

    <?php
    $tags = $model->getSelectedTags();
    $allTags = \common\models\Tag::getAll();
    echo Select2::widget([
        'name' => 'tags',
        'id' => 'post_tags',
        'value' => $tags,
        'class' => 'form-control',
        'data' => $allTags,
        'options' => ['multiple' => true, 'dir' => Yii::$app->params['direction'], 'placeholder' => Yii::t('app', 'Tags')],
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
            'options' => ['multiple' => true, 'dir' => Yii::$app->params['direction'], 'placeholder' => Yii::t('app', 'Keywords')],
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
        <div style="width:80px;">
            <?= $form->field($model, 'minute')->textInput(['value'=>($createdAt !== null) ? $createdAt->format('i') : '59','class'=>'form-control center','maxlength' => true]) ?>
        </div>
        <div style="width:80px;">
            <?= $form->field($model, 'hour')->textInput(['value'=>!empty($createdAt !== null) ? $createdAt->format('H') : '23','class'=>'form-control center','maxlength' => true]) ?>
        </div>
        <div>
            <?= $form->field($model, 'date')->textInput(['value' =>  !empty($createdAt !== null) ? Yii::$app->date->asDate($createdAt) : Yii::$app->date->asDate('now', 'php:Y-m-d'), 'class' => 'form-control center', 'maxlength' => true]) ?>
        </div>

    </div>
    <div class="clear"></div>
    <?= $form->field($model, 'post_id')->hiddenInput(); ?>
    <?= $form->field($model, 'enable_comments')->checkbox(); ?>
    <?= $form->field($model, 'pin_post')->checkbox(); ?>
    <div class="form-group center">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
<?= Html::endPanel() ?>