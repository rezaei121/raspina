<?php
use backend\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\post\models\CommentSearch */
/* @var $model backend\modules\post\models\Comment */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Comments');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Posts'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= Html::beginPanel($this->title ) ?>
    <?= Html::beginForm(['comment/bulk'],'post') ?>
    <?= Html::dropDownList('action','confirmed',['delete' => Yii::t('app','Delete'),'confirmed' => Yii::t('app','Confirmed')],['class'=>'dropdown fa-bulk-dropdown',]) ?>
    <?= Html::submitButton(Yii::t('app','Do'), ['class' => 'btn btn-primary fa-bulk-button',]) ?>
    <div class="fa-br"></div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],
            [
                'attribute' => 'post_title',
                'format' => 'raw',
                'value' => function($model){
                    $sub_title = $model->post->title;
                    if(mb_strlen($sub_title,'UTF-8') > 27)
                    {
                        $sub_title = mb_substr($model->post->title,0,30,'UTF-8') . '...';
                    }
                    $link = Html::a($sub_title,['default/view?id=' . $model->post_id]);
                    return $link;
                }
            ],
            'name',
            'email:email',
            [
                'attribute' => 'status',
                'value' => function($model){
                    $status = $model->getCommentStatus();
                    return $status[$model->status];
                },
                'contentOptions' => ['width' => '10%'],
                'filter' => $model->getCommentStatus()
            ],
            [
                'attribute' => 'create_time',
                'value' => function($model){
                    return  Yii::$app->date->pdate($model->create_time);
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {delete}',
            ],
        ],
    ]); ?>
    <?= Html::endForm() ?>
<?= Html::endPanel() ?>
