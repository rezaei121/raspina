<?php
use dashboard\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel dashboard\modules\post\models\CommentSearch */
/* @var $model dashboard\modules\post\models\Comment */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Comments');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Posts'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= Html::beginPanel($this->title ) ?>
    <?= Html::beginForm(['comment/group-actions'],'post') ?>
    <?= Html::dropDownList('action','confirmed',['approve' => Yii::t('app','Approve'), 'delete' => Yii::t('app','Delete')],['class'=>'dropdown fa-bulk-dropdown',]) ?>
    <?= Html::submitButton(Yii::t('app','Apply'), ['class' => 'btn-sm btn-primary fa-bulk-button', 'data-confirm' => Yii::t('app', 'Are you sure you want to do?')]) ?>
    <div class="fa-br"></div>
<br>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => "{items}\n{pager}",
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                'headerOptions' => ['class'=>'fit'],
                'contentOptions' => ['class' => 'fit center'],
            ],
            [
                'attribute' => 'post_title',
                'format' => 'raw',
                'value' => function($model){
                    $link = Html::a($model->post->title,['default/view', 'id' => $model->post_id]);
                    return $link;
                },
                'headerOptions' => ['class'=>'low-display-priority'],
                'filterOptions' => ['class'=>'low-display-priority'],
                'contentOptions' => ['class' => 'low-display-priority'],
            ],
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function($model){
                    $link = Html::a($model->name,['comment/view', 'id' => $model->id]);
                    return $link;
                },
            ],
            [
                'attribute' => 'email',
                'format' => 'email',
                'headerOptions' => ['class'=>'auto-fit'],
                'filterOptions' => ['class'=>'auto-fit'],
                'contentOptions' => ['class' => 'auto-fit'],
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function($model){
                    $status = $model->getCommentStatus();

                    $classLabel = 'label-blue';
                    if($model->status == 0) $classLabel = 'label-yellow';
                    if($model->status == 1) $classLabel = 'label-green';

                    return  "<span class=\"label {$classLabel}\">{$status[$model->status]}</span>";
                },
                'contentOptions' => ['class' => 'fit'],
                'headerOptions' => ['class'=>'fit'],
                'filter' => $model->getCommentStatus()
            ],
            [
                'attribute' => 'created_at',
                'value' => function($model){
                    return  Yii::$app->date->asDateTime($model->created_at);
                },
                'headerOptions' => ['class'=>'auto-fit'],
                'filterOptions' => ['class'=>'auto-fit'],
                'contentOptions' => ['class' => 'auto-fit center ltr'],
            ],
            [
                'class' => \dashboard\components\grid\ActionColumn::className(),
                'contentOptions' => ['class' => 'action-column auto-fit'],
                'headerOptions' => ['class'=>'auto-fit'],
                'template' => '{view} {delete}'
            ],
        ],
    ]); ?>
    <?= Html::endForm() ?>
<?= Html::endPanel() ?>
