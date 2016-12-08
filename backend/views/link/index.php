<?php
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Links');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-md-4">
    <div class="panel panel-default">
        <div class="panel-heading"><?= Yii::t('app','Create Link') ?></div>
        <div class="panel-body">

            <div class="link-create">

                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>

            </div>


        </div>
    </div>
</div>

<div class="col-md-8">
    <div class="panel panel-default">
        <div class="panel-heading"><?= $this->title ?></div>
        <div class="panel-body">

<div class="link-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'title',
//                'contentOptions' => ['width' => '46.5%'],
            ],
            [
                'attribute' => 'url',
                'contentOptions' => ['style' => 'text-align:left;direction:ltr'],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
            ],
        ],
    ]); ?>

</div>
        </div>
    </div>
</div>
