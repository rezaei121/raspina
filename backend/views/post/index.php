<?php
use yii\grid\GridView;
$this->title = Yii::t('app', 'Posts');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading"><?= $this->title ?></div>
        <div class="panel-body">

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        [
            'attribute' => 'title',
            'value' => 'title',
            'contentOptions' => ['width' => '50%']
        ],
        [
            'attribute' => 'status',
            'value' => function($model){
                $postStatus = $model->postStatus();
                return $postStatus[$model->status];
            },
            'contentOptions' => ['width' => '15%'],
            'filter' => $model->postStatus()
        ],
        [
            'attribute' => 'view',
            'contentOptions' => ['width' => '10%'],
            'filter' => ''
        ],
        [
            'attribute' => 'create_time',
            'value' => function($model){
                return Yii::$app->date->pdate($model->create_time);
            },
            'contentOptions' => ['width' => '15%'],
            'filter' => ''
        ],
        [
            'class' => 'yii\grid\ActionColumn'
        ],
    ],
]) ?>

        </div>
    </div>
</div>