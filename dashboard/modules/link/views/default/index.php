<?php
use yii\grid\GridView;
use dashboard\components\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model dashboard\modules\link\models\Link */

$this->title = Yii::t('app', 'Links');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= Html::beginPanel(Yii::t('app', 'Create Link')) ?>
                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>
<?= Html::endPanel() ?>

<?= Html::beginPanel($this->title) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "{items}\n{pager}",
        'columns' => [
            [
                'attribute' => 'title',
            ],
            [
                'attribute' => 'url',
                'contentOptions' => ['style' => 'text-align:left;direction:ltr'],
            ],
            [
                'class' => \dashboard\components\grid\ActionColumn::className(),
                'contentOptions' => ['class' => 'action-column fit'],
                'headerOptions' => ['class'=>'fit'],
                'template' => '{update} {delete}'
            ],
        ],
    ]); ?>
<?= Html::endPanel() ?>
