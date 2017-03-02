<?php
use yii\grid\GridView;
use backend\helpers\Html;
use developit\pdate\Date;

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
            'attribute' => 'create_time',
            'value' => function($model){
                return Date::widget(['value' => $model->create_time]);
            },
            'contentOptions' => ['width' => '15%'],
        ],
        [
            'class' => 'yii\grid\ActionColumn'
        ],
    ],
]) ?>
<?= Html::endPanel() ?>