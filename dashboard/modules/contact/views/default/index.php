<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model dashboard\modules\contact\models\Contact */
/* @var $searchModel dashboard\modules\contact\models\ContactSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Contacts');
$this->params['breadcrumbs'][] = $this->title;

$status = $model->getStatusList();
?>
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading"><?= $this->title ?></div>
        <div class="panel-body">

<div class="contact-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= Html::beginForm(['bulk'],'post') ?>
    <?= Html::dropDownList('action','',['delete' => Yii::t('app','Delete')],['class'=>'dropdown fa-bulk-dropdown',]) ?>
    <?= Html::submitButton(Yii::t('app','Apply'), ['class' => 'btn-sm btn-primary fa-bulk-button',]) ?>
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
                'contentOptions' => ['class' => 'fit'],
            ],
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function($model){
                    $link = Html::a($model->name,['default/view', 'id' => $model->id]);
                    return $link . '<br><div class="comment-preview">' .nl2br($model->message) . '</div>';
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
                'attribute' => 'site',
                'format' => 'raw',
                'value' => function($model) {
                    return  Html::a($model->site, $model->site,['target'=>'_blank']);
                },
                'headerOptions' => ['class'=>'auto-fit'],
                'filterOptions' => ['class'=>'auto-fit'],
                'contentOptions' => ['class' => 'auto-fit'],
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function($model) use($status) {
                    $classLabel = 'label-blue';
                    if($model->status == 0) $classLabel = 'label-yellow';
                    if($model->status == 1) $classLabel = 'label-green';

                    return  "<span class=\"label {$classLabel}\">{$status[$model->status]}</span>";
                },
                'headerOptions' => ['class'=>'fit'],
                'filterOptions' => ['class'=>'fit'],
                'contentOptions' => ['class' => 'fit center'],
                'filter' => $status
            ],
            [
                'attribute' => 'created_at',
                'value' => function($model){
                    return  Yii::$app->date->asDatetime($model->created_at);
                },
                'headerOptions' => ['class'=>'auto-fit'],
                'filterOptions' => ['class'=>'auto-fit'],
                'contentOptions' => ['class' => 'auto-fit ltr'],
                'filter' => $status
            ],
            [
                'class' => \dashboard\components\grid\ActionColumn::className(),
                'headerOptions' => ['class'=>'auto-fit'],
                'filterOptions' => ['class'=>'auto-fit'],
                'contentOptions' => ['class' => 'action-column auto-fit'],
                'template' => '{view}'
            ],
        ],
    ]); ?>

</div>

        </div>
    </div>
</div>
