<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\post\models\Post */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$postStatus = $model->postStatus();
?>

<div class="col-md-2">
    <div class="panel panel-default">
        <div class="panel-heading panel-status"><?= Yii::t('app','Author') ?></div>
        <div class="panel-body">
            <!-- -->
            <div class="panel-body-detail">
                <?php
                $authorDetail = $model->getAuthor()->one();
                echo "{$authorDetail->last_name} {$authorDetail->surname}"
                ?>
            </div>
            <!-- -->
        </div>
    </div>
</div>

<div class="col-md-2">
    <div class="panel panel-default">
        <div class="panel-heading panel-status"><?= Yii::t('app','Status') ?></div>
        <div class="panel-body">
            <!-- -->
            <div class="panel-body-detail"><?= $postStatus[$model->status] ?></div>
            <!-- -->
        </div>
    </div>
</div>

<div class="col-md-2">
    <div class="panel panel-default">
        <div class="panel-heading panel-status"><?= Yii::t('app','View') ?></div>
        <div class="panel-body">
            <!-- -->
            <div class="panel-body-detail"><?= $model->view ?></div>
            <!-- -->
        </div>
    </div>
</div>

<div class="col-md-2">
    <div class="panel panel-default">
        <div class="panel-heading panel-status"><?= Yii::t('app','Created At') ?></div>
        <div class="panel-body">
            <!-- -->
            <div class="panel-body-detail ltr"><?= Yii::$app->date->asDateTime($model->created_at) ?></div>
            <!-- -->
        </div>
    </div>
</div>

<div class="col-md-2">
    <div class="panel panel-default">
        <div class="panel-heading panel-status"><?= Yii::t('app','Updated At') ?></div>
        <div class="panel-body">
            <!-- -->
            <div class="panel-body-detail ltr"><?= Yii::$app->date->asDateTime($model->updated_at) ?></div>
            <!-- -->
        </div>
    </div>
</div>

<div class="col-md-2">
    <div class="panel panel-default">
        <div class="panel-heading panel-status"><?= Yii::t('app','Actions') ?></div>
        <div class="panel-body">
            <!-- -->
            <div class="panel-body-detail" style="margin-top: -6px;">
                        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn-sm btn-primary']) ?>
                        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                            'class' => 'btn-sm btn-danger',
                            'data' => [
                                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                'method' => 'post',
                            ],
                        ]) ?>
            </div>
            <!-- -->
        </div>
    </div>
</div>


<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading"><?= $this->title ?></div>
        <div class="panel-body">

<div class="post-view">
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
        </div>
    </div>
</div>