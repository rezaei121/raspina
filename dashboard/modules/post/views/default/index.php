<?php
use yii\grid\GridView;
use dashboard\helpers\Html;

/* @var $model dashboard\modules\post\models\Post */

$this->title = Yii::t('app', 'Posts');
$this->params['breadcrumbs'][] = $this->title;

$postStatus = $model->postStatus();
?>

<?= Html::beginPanel($this->title) ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'layout' => "{items}\n{pager}",
    'columns' => [
        [
            'attribute' => 'title',
            'format' => 'raw',
            'value' => function($model)
            {
                return Html::a($model->title, ['view','id'=>$model->id]);
            }
        ],
        [
            'attribute' => 'status',
            'format' => 'raw',
            'value' => function($model) use($postStatus) {
                $classLabel = 'label-blue';
                if($model->status == 0) $classLabel = 'label-yellow';
                if($model->status == 2) $classLabel = 'label-green';

                return  "<span class=\"label {$classLabel}\">{$postStatus[$model->status]}</span>";
            },
            'headerOptions' => ['class'=>'auto-fit'],
            'filterOptions' => ['class'=>'auto-fit'],
            'contentOptions' => ['class' => 'auto-fit align-center'],
            'filter' => $postStatus
        ],
        [
            'attribute' => 'view',
            'headerOptions' => ['class'=>'auto-fit'],
            'filterOptions' => ['class'=>'auto-fit'],
            'contentOptions' => ['class' => 'auto-fit align-center'],
        ],
        [
            'attribute' => 'created_at',
            'value' => function($model){
                return  Yii::$app->date->asDateTime($model->created_at);
            },
            'headerOptions' => ['class'=>'auto-fit'],
            'filterOptions' => ['class'=>'auto-fit'],
            'contentOptions' => ['class' => 'auto-fit align-center ltr'],
        ],
        [
            'class' => \dashboard\components\grid\ActionColumn::className(),
            'headerOptions' => ['class'=>'auto-fit'],
            'filterOptions' => ['class'=>'auto-fit'],
            'contentOptions' => ['class' => 'action-column auto-fit'],
            'template' => '{update}'
        ],
    ],
]) ?>
<?= Html::endPanel() ?>