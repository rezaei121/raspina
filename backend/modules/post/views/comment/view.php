<?php

use backend\helpers\Html;
use yii\widgets\DetailView;
use developit\pdate\Date;

/* @var $this yii\web\View */
/* @var $model backend\modules\post\models\Comment */

$this->title = Yii::t('app', 'Comment View');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Posts'), 'url' => ['post/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Comments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= Html::beginPanel($this->title) ?>
        <?php
            if($model->status == 0)
            {
                echo Html::a(Yii::t('app', 'Accept'), ['bulk', 'id' => $model->id,'action' => 'confirmed'], ['class' => 'btn btn-success']);
            }
        ?>
        <?= Html::a(Yii::t('app', 'Reply'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    <?php $postStatus = $model->getCommentStatus(); ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'ip',
            [
                'label'  => Yii::t('app', 'Post Title'),
                'format' => 'raw',
                'value'  => Html::a($model->post->title,['post/view?id=' . $model->post_id]),
            ],
            'email:email',
            [
                'label'  => Yii::t('app', 'Status'),
                'value'  => $postStatus[$model->status],
            ],
            [
                'label'  => Yii::t('app', 'Create Time'),
                'value'  => Date::widget(['value' => $model->create_time]),
            ],
            'text:ntext',
            'reply_text:html',
        ],
    ]) ?>
<?= Html::endPanel() ?>