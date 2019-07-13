<?php
use yii\grid\GridView;
use app\components\helpers\Html;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model dashboard\modules\post\models\Category */

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
        'layout' => "{items}\n{pager}",
        'columns' => [
            [
                'attribute' => 'title',
                'value' => 'title',
            ],
            [
                'class' => \app\components\grid\ActionColumn::className(),
                'contentOptions' => ['class' => 'action-column fit'],
                'headerOptions' => ['class'=>'fit'],
                'template' => '{update} {delete}'
            ],
        ],
    ]); ?>
<?= Html::endPanel() ?>
