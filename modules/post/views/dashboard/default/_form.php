<?php
use app\components\helpers\Html;
use \app\components\helpers\Raspina;
use app\components\widgets\ActiveForm;
use app\modules\post\models\Category;
use app\modules\post\models\PostCategory;
use app\modules\post\models\Tag;
use dosamigos\tinymce\TinyMce;
use kartik\select2\Select2;

?>
<?= Html::beginPanel($this->title . Html::submitButton(Yii::t('app', 'Get Auto Saved Text'), ['class' => 'btn btn-primary auto-saved-btn'])) ?>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= Select2::widget([
        'name' => 'post_categories',
        'id' => 'post-post_categories',
        'value' => PostCategory::getSelectedCategories($model->id),
        'class' => 'form-control',
        'data' => \yii\helpers\ArrayHelper::map(Category::getAll(),'id','title'),
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
            'init_instance_callback' => 'done_typing',
            'content_css' => Raspina::url() . 'app/web/css/tinymce.css',
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
                'init_instance_callback' => 'done_typing',
                'directionality' => Yii::$app->params['direction'],
                'content_css' => Raspina::url() . 'app/web/css/tinymce.css',
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
    $allTags = Tag::getAll();
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
        $keywords = $model->getSelectedKeywords();
        echo Select2::widget([
            'name' => 'keywords',
            'id' => 'post_keywords',
            'value' => $keywords,
            'class' => 'form-control',
            'data' => $keywords,
            'options' => ['multiple' => true, 'dir' => Yii::$app->params['direction'], 'placeholder' => Yii::t('app', 'Keywords')],
            'pluginOptions' => [
                'tags' => true,
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
