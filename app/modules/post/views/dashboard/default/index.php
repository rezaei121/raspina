<?php
use yii\grid\GridView;
use app\components\helpers\Html;

/* @var $model dashboard\modules\post\models\Post */

$this->title = Yii::t('app', 'Posts');
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];

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
                $value = Html::a($model->title, ['view','id' => $model->id]);
                $shareLink = Yii::$app->params['url'] . 'post/default/share-link/' . Yii::$app->hashids->encode($model->id);
                $value .= '
<div class="input-group input-group-share-link">
   <span class="input-group-addon share-link-copy" id="basic-addon1">Copy</span>
  <input type="text" class="form-control share-link" value="'.$shareLink.'" aria-describedby="basic-addon2">
</div>';
                return $value;
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
            'contentOptions' => ['class' => 'auto-fit center'],
            'filter' => $postStatus
        ],
        [
            'attribute' => 'view',
            'headerOptions' => ['class'=>'auto-fit'],
            'filterOptions' => ['class'=>'auto-fit'],
            'contentOptions' => ['class' => 'auto-fit center'],
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
            'class' => \app\components\grid\ActionColumn::className(),
            'headerOptions' => ['class'=>'auto-fit'],
            'filterOptions' => ['class'=>'auto-fit'],
            'contentOptions' => ['class' => 'action-column auto-fit'],
            'template' => '{update}'
        ],
    ],
]) ?>
<?= Html::endPanel() ?>
