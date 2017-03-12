<?php
use backend\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\file\models\FileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Files');
$this->params['breadcrumbs'][] = $this->title;

$setting = Yii::$app->setting->get();
?>
<?= Html::beginPanel($this->title) ?>
    <?php Yii::$app->session->getFlash(''); ?>
    <?= Html::beginForm(['bulk'],'post') ?>
    <?= Html::dropDownList('action','',['delete' => Yii::t('app','Delete')],['class'=>'dropdown fa-bulk-dropdown',]) ?>
    <?= Html::submitButton(Yii::t('app','Do'), ['class' => 'btn btn-primary fa-bulk-button',]) ?>
    <div class="fa-br"></div>
    <?php if($filesInfo['count']) echo Yii::t('app', 'filesInfo',['count' => $filesInfo['count'], 'sum' => $filesInfo['sum']]); ?>
    <div class="fa-br"></div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function($model) use($setting){
                    $url = $setting['url'] . 'file/download/' . Yii::$app->hashids->encode($model->id);
                    return '<a href="'.$url.'" target="_blank">' . $model->name . '</a><br><input type="text" class="upload-box-link" value="'.$url.'">';
                }
            ],
            'extension',
            [
                'attribute' => 'size',
                'value' => function($model){
                    if ($model->size<1048676)
                        return number_format($model->size/1024,1) . ' ' . Yii::t('app','KB');
                    else
                        return number_format($model->size/1048576,1) . ' ' . Yii::t('app','MB');
                }
            ],
            [
                'attribute' => 'download_count'
            ],
            [
                'attribute' => 'upload_date',
                'value' => function($model){
                    return Yii::$app->date->pdate($model->upload_date);
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}'
            ],
        ],
    ]); ?>
<?= Html::endPanel() ?>
