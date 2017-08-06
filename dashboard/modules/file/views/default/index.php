<?php
use dashboard\components\helpers\Html;
use yii\grid\GridView;

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
                    return '<a href="'.$url.'" target="_blank"><input style="background-color:#EFEFEF; cursor: pointer" type="text" class="form-control readonly" value="'.$model->name.'"></a><br><input type="text" class="upload-box-link form-control ltr" value="'.$url.'">';
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
                'class' => \dashboard\components\grid\ActionColumn::className(),
                'contentOptions' => ['class' => 'action-column fit'],
                'headerOptions' => ['class'=>'fit'],
                'template' => '{delete}'
            ],
        ],
    ]); ?>
<?= Html::endPanel() ?>
