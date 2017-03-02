<?php
use yii\grid\GridView;
use backend\helpers\Html;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Categories');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Posts'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= Html::beginPanel(Yii::t('app', 'Create Category')) ?>
                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>
<?= Html::endPanel() ?>

<?= Html::beginPanel($this->title) ?>
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
<?= Html::endPanel() ?>
