<?php
use dashboard\helpers\Html;

/* @var $this yii\web\View */
/* @var $model dashboard\modules\post\models\Post */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$postStatus = $model->postStatus();
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
    <?= Html::a($model->getComments()->count('id'), ['comment/index', 'CommentSearch[post_id]' => $model->id]) ?>
<?= Html::endPanel() ?>

<div class="clear"></div>

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
            <span class="bold"><?= Yii::t('app', 'Tags') ?>:</span> <?= $model->tags? $model->tags : Yii::t('app', '(no set)'); ?>
            <br>
            <span class="bold"><?= Yii::t('app', 'Keywords') ?>:</span> <?= $model->keywords? $model->keywords : Yii::t('app', '(no set)'); ?>
            <br>
            <span class="bold"><?= Yii::t('app', 'Meta Description') ?>:</span> <?= $model->meta_description? $model->meta_description : Yii::t('app', '(no set)'); ?>
        </p>
    </div>
<?= Html::endPanel() ?>
