<?php
use yii\grid\GridView;
use backend\helpers\Html;

/* @var $model backend\modules\post\models\Post */

$this->title = Yii::t('app', 'Posts');
$this->params['breadcrumbs'][] = $this->title;

$postStatus = $model->postStatus();
?>

<?= Html::beginPanel($this->title) ?>
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
            'value' => function($model) use($postStatus) {
                return $postStatus[$model->status];
            },
            'contentOptions' => ['width' => '15%'],
            'filter' => $postStatus
        ],
        [
            'attribute' => 'view',
            'contentOptions' => ['width' => '10%'],
        ],
        [
            'attribute' => 'created_at',
            'value' => function($model){
                return  Yii::$app->date->pdate($model->created_at);
            },
            'contentOptions' => ['width' => '15%'],
        ],
        [
            'class' => 'yii\grid\ActionColumn'
        ],
    ],
]) ?>
<?= Html::endPanel() ?>