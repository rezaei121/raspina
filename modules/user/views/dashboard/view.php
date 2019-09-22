<?php
use app\components\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model dashboard\modules\user\models\User */

$this->title = "$model->last_name $model->surname - {$model->username}";
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= Html::beginPanel(Yii::t('app','Name'), 'col-md-3 col-sm-6 col-xs-12',['panel', 'panel-default'], ['panel-heading', 'panel-status'], ['panel-body', 'panel-body-detail']) ?>
    <?= "{$model->last_name} {$model->surname}" ?>
<?= Html::endPanel() ?>

<?= Html::beginPanel(Yii::t('app','Username'), 'col-md-3 col-sm-6 col-xs-12',['panel', 'panel-default'], ['panel-heading', 'panel-status'], ['panel-body', 'panel-body-detail']) ?>
    <?= $model->username ?>
<?= Html::endPanel() ?>

<?= Html::beginPanel(Yii::t('app','Email'), 'col-md-3 col-sm-6 col-xs-12',['panel', 'panel-default'], ['panel-heading', 'panel-status'], ['panel-body', 'panel-body-detail']) ?>
    <?= $model->email ?>
<?= Html::endPanel() ?>

<?= Html::beginPanel(Yii::t('app','Status'), 'col-md-3 col-sm-6 col-xs-12',['panel', 'panel-default'], ['panel-heading', 'panel-status'], ['panel-body', 'panel-body-detail']) ?>
    <?php
        $status = $model->getStatus();
        echo $status[$model->status];
    ?>
<?= Html::endPanel() ?>

<div class="clear"></div>

<?= Html::beginPanel(Yii::t('app','Posts')) ?>
<?php Pjax::begin(); ?>
<?= GridView::widget([
    'dataProvider' => $postDataProvider,
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
        ]
    ],
]) ?>
<?php Pjax::end(); ?>
<?= Html::endPanel() ?>

<?= Html::beginPanel(Yii::t('app','Files')) ?>
<?php Pjax::begin(); ?>
<?= GridView::widget([
    'dataProvider' => $fileDataProvider,
    'layout' => "{items}\n{pager}",
    'columns' => [
        [
            'attribute' => 'name',
            'label' => Yii::t('app', 'File'),
            'format' => 'raw',
            'value' => function($model) {
                $url = \Yii::$app->params['url'] . 'file/download/' . Yii::$app->hashids->encode($model->id);
                return '<input type="text" class="upload-box-link form-control ltr" value="'.$url.'">';
            },
        ],
        [
            'attribute' => 'size',
            'value' => function($model){
                if ($model->size<1048676)
                    return number_format($model->size/1024,1) . ' ' . Yii::t('app','KB');
                else
                    return number_format($model->size/1048576,1) . ' ' . Yii::t('app','MB');
            },
            'headerOptions' => ['class'=>'auto-fit'],
            'filterOptions' => ['class'=>'auto-fit'],
            'contentOptions' => ['class' => 'auto-fit ltr center'],
        ],
        [
            'attribute' => 'download_count',
            'headerOptions' => ['class'=>'auto-fit'],
            'filterOptions' => ['class'=>'auto-fit'],
            'contentOptions' => ['class' => 'auto-fit ltr center'],

        ]
    ],
]); ?>
<?php Pjax::end(); ?>
<?= Html::endPanel() ?>

<?= Html::beginPanel(Yii::t('app','Reply Comments')) ?>
<?php Pjax::begin(); ?>
<?= GridView::widget([
    'dataProvider' => $commentDataProvider,
    'layout' => "{items}\n{pager}",
    'columns' => [
        [
            'attribute' => 'reply_text',
            'label' => Yii::t('app', 'Text'),
            'format' => 'raw',
            'value' => function($model){
                $postLink = Html::a($model->post->title, ['/post/default/view', 'id' => $model->post_id]);
                return nl2br($model->reply_text) . '<br><div class="comment-text">' . $postLink . '<br>' . nl2br($model->text) . '</div>';
            },
        ]
    ],
]); ?>
<?php Pjax::end(); ?>
<?= Html::endPanel() ?>


