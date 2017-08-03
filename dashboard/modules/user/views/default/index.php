<?php
use yii\grid\GridView;
use dashboard\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<?= Html::beginPanel($this->title) ?>
<div class="user-index">
    <?= Html::a(Yii::t('app', 'Create User'), ['create'], ['class' => 'btn btn-success']) ?>
    <div class="clear"></div> <br>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "{items}\n{pager}",
        'columns' => [
            [
                'attribute' => 'last_name',
                'format' => 'raw',
                'value' => function($model)
                {
                    return Html::a("{$model->last_name} {$model->surname} ({$model->username})", ['view', 'id' => $model->id]);
                }
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function($model){

                    $status = $model->getStatus();

                    $classLabel = 'label-blue';
                    if($model->status == 0) $classLabel = 'label-yellow';
                    if($model->status == 10) $classLabel = 'label-green';

                    return  "<span class=\"label {$classLabel}\">{$status[$model->status]}</span>";
                },
                'contentOptions' => ['class' => 'auto-fit'],
                'headerOptions' => ['class'=>'auto-fit'],
            ],
            [
                'class' => \dashboard\components\grid\ActionColumn::className(),
                'contentOptions' => ['class' => 'action-column fit'],
                'headerOptions' => ['class'=>'fit'],
                'template' => '{update} {delete}'
            ],
        ],
    ]); ?>
</div>
<?= Html::endPanel() ?>
