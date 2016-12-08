<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\controllers\FileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Files');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading"><?= $this->title ?></div>
        <div class="panel-body">

<div class="file-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
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
                'value' => function($model){
                    $setting = Yii::$app->setting->get();
                    $sult = $setting['sult'];
                    $hashids = new \common\components\hashids\Hashids($sult,5);
                    $url = $setting['url'] . 'file/download/' . $hashids->encode($model->id);
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
                },
                'filter' => ''
            ],
            [
                'attribute' => 'download_count',
                'filter' => ''
            ],
            [
                'attribute' => 'upload_date',
                'value' => function($model){
                    return Yii::$app->date->pdate($model->upload_date);
                },
                'filter' => ''
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}'
            ],
        ],
    ]); ?>

</div>

        </div>
    </div>
</div>
