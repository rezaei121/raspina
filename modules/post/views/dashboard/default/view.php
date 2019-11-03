<?php
use app\components\helpers\Html;
use \app\modules\post\models\Comment;

$this->registerCssFile(Yii::$app->homeUrl . 'web/css/prism.css');
$this->registerJsFile( '@web/web/js/prism.js');

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$postStatus = $model->postStatus();

$shareLink = Yii::$app->params['url'] . 'post/default/share-link/' . Yii::$app->hashids->encode($model->id);
?>

<?= Html::beginPanel(Yii::t('app','Author'), 'col-md-2 col-xs-12 col-sm-4',['panel', 'panel-default'], ['panel-heading', 'panel-status'], ['panel-body', 'panel-body-detail']) ?>
    <?php
    $authorDetail = $model->getCreatedBy()->one();
    echo "{$authorDetail->last_name} {$authorDetail->surname}"
    ?>
<?= Html::endPanel() ?>

<?= Html::beginPanel(Yii::t('app','Status'), 'col-md-2 col-xs-12 col-sm-4',['panel', 'panel-default'], ['panel-heading', 'panel-status'], ['panel-body', 'panel-body-detail']) ?>
    <?= $postStatus[$model->status] ?>
<?= Html::endPanel() ?>

<?= Html::beginPanel(Yii::t('app','View'), 'col-md-2 col-xs-12 col-sm-4',['panel', 'panel-default'], ['panel-heading', 'panel-status'], ['panel-body', 'panel-body-detail']) ?>
    <?= $model->view ?>
<?= Html::endPanel() ?>

<?= Html::beginPanel(Yii::t('app','Created At'), 'col-md-2 col-xs-12 col-sm-4',['panel', 'panel-default'], ['panel-heading', 'panel-status'], ['panel-body', 'panel-body-detail ltr']) ?>
    <?= Yii::$app->date->asDateTime($model->created_at) ?>
<?= Html::endPanel() ?>

<?= Html::beginPanel(Yii::t('app','Updated At'), 'col-md-2 col-xs-12 col-sm-4',['panel', 'panel-default'], ['panel-heading', 'panel-status'], ['panel-body', 'panel-body-detail ltr']) ?>
    <?= Yii::$app->date->asDateTime($model->updated_at) ?>
<?= Html::endPanel() ?>

<?= Html::beginPanel(Yii::t('app','Comments'), 'col-md-2 col-xs-12 col-sm-4',['panel', 'panel-default'], ['panel-heading', 'panel-status'], ['panel-body', 'panel-body-detail']) ?>
    <?= Html::a(Comment::find()->where(['post_id' => $model->id])->count(), ['comment/index', 'CommentSearch[post_id]' => $model->id]) ?>
<?= Html::endPanel() ?>

<div class="clear"></div>

<?= Html::beginPanel("", 'col-md-12', ['panel', 'panel-default'], ['']) ?>
<div class="input-group input-group-s-link">
    <span class="input-group-addon s-link-copy" id="basic-addon1">Copy</span>
    <input type="text" class="form-control s-link" value="<?= $shareLink ?>" aria-describedby="basic-addon2">
</div>
<?= Html::endPanel() ?>


<?= Html::beginPanel($this->title) ?>
    <div class="post-view">
        <?= Html::actionButtons($model) ?>

        <?= $model->short_text ?>
        <?= $model->more_text ?>
        <hr>
        <p>
            <span class="bold"><?= Yii::t('app', 'Categories') ?>:</span>
            <?php
            $categories = $model->getSelectedCategoriesTitle();
            echo $categories? $categories : Yii::t('app', '(no set)');
            ?>
            <br>
            <span class="bold"><?= Yii::t('app', 'Tags') ?>:</span>
            <?php
            $tags = [];
            foreach ($model->tags() as $tag => $slug)
            {
                $tags[] = $tag;
            }
            echo implode(', ', $tags);
            ?>
            <br>
            <span class="bold"><?= Yii::t('app', 'Keywords') ?>:</span> <?= $model->keywords? $model->keywords : Yii::t('app', '(no set)'); ?>
            <br>
            <span class="bold"><?= Yii::t('app', 'Meta Description') ?>:</span> <?= $model->meta_description? $model->meta_description : Yii::t('app', '(no set)'); ?>
        </p>
    </div>
<?= Html::endPanel() ?>
