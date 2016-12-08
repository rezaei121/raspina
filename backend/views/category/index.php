<?php
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Categories');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Posts'), 'url' => ['post/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-md-4">
    <div class="panel panel-default">
        <div class="panel-heading"><?= Yii::t('app','Create Link') ?></div>
        <div class="panel-body">

            <div class="category-create">
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

<div class="category-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'title',
                'value' => 'title',
                'contentOptions' => ['width' => '91%']
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}'
            ],
        ],
    ]); ?>

</div>
        </div>
    </div>
</div>
