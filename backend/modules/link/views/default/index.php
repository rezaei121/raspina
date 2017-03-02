<?php
use yii\grid\GridView;
use backend\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model backend\modules\link\models\Link */

$this->title = Yii::t('app', 'Links');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= Html::beginPanel($this->title, 4) ?>
                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>
<?= Html::endPanel() ?>

<?= Html::beginPanel($this->title, 8) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'title',
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
<?= Html::endPanel() ?>
