<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Post */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading"><?= $this->title ?></div>
        <div class="panel-body">

<div class="post-view">
    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?php $postStatus = $model->postStatus(); ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            [
                'label'  => Yii::t('app', 'Categories'),
                'value'  => $model->getSelectedCategoriesTitle($model->id),
            ],
            'short_text:html',
            'more_text:html',
            'tags:ntext',
            'keywords:ntext',
            'meta_description:ntext',
            [
                'label'  => Yii::t('app', 'Status'),
                'value'  => $postStatus[$model->status],
            ],
            'view:ntext',
            [
                'label'  => Yii::t('app', 'Create Time'),
                'value'  => Yii::$app->date->pdate($model->created_at),
            ],
            [
                'label'  => Yii::t('app', 'Update Time'),
                'value'  => Yii::$app->date->pdate($model->update_time),
            ]
        ],
    ]) ?>

</div>

        </div>
    </div>
</div>
