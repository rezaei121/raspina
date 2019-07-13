<?php

use app\components\grid\ActionColumn;
use app\components\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel dashboard\modules\file\models\FileSearch */
/* @var $searchModel dashboard\modules\file\models\File */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Files');
$this->params['breadcrumbs'][] = $this->title;

$setting = Yii::$app->setting->get();
?>

<?= Html::beginPanel(Yii::t('app', 'Upload File')) ?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>
<?= Html::endPanel() ?>

<?= Html::beginPanel($this->title) ?>
    <?php if($filesInfo['count']) echo Yii::t('app', 'So far, {count} files of {sum} MB have been uploaded',['count' => $filesInfo['count'], 'sum' => $filesInfo['sum']]); ?>
    <div class="fa-br"></div>
    <br>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => "{items}\n{pager}",
        'columns' => [
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function($model) use($setting){
                    $url = $setting['url'] . 'file/download/' . Yii::$app->hashids->encode($model->id);
                    $owner_url = Url::to(['/user/default/view', 'id' => $model->user_id]);
                    return '
                    <a href="'.$owner_url.'" target="_blank"><input style="background-color:#EFEFEF; cursor: pointer; width:49%; float:right; margin-left:2%;" type="text" class="form-control readonly" value="'.$model->last_name.' '.$model->surname.'"></a>
                    <a href="'.$url.'" target="_blank"><input style="background-color:#EFEFEF; cursor: pointer; width:49%; float:right" type="text" class="form-control readonly" value="'.$model->name.'"></a>
                    <div class="clear"></div>
                    <br>
                    <input type="text" class="upload-box-link form-control ltr" value="'.$url.'">';
                },
            ],
            [
                'attribute' => 'extension',
                'headerOptions' => ['class'=>'fit'],
                'filterOptions' => ['class'=>'fit'],
                'contentOptions' => ['class' => 'fit ltr center'],
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

            ],
            [
                'attribute' => 'uploaded_at',
                'value' => function($model){
                    return Yii::$app->date->asDatetime($model->uploaded_at);
                },
                'headerOptions' => ['class'=>'auto-fit'],
                'filterOptions' => ['class'=>'auto-fit'],
                'contentOptions' => ['class' => 'auto-fit ltr'],
            ],
            [
                'class' => ActionColumn::className(),
                'contentOptions' => ['class' => 'action-column fit'],
                'headerOptions' => ['class'=>'fit'],
                'template' => '{delete}'
            ],
        ],
    ]); ?>
<?= Html::endPanel() ?>
