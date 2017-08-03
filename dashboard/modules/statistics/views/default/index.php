<?php
use yii\grid\GridView;
use dashboard\helpers\Html;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model dashboard\modules\statistics\models\Statistics */

$this->registerJsFile('@web/web/js/chart.bundle.min.js');

$this->registerJsFile(Yii::$app->homeUrl . 'web/js/statistics_chart_config.js');

$this->title = Yii::t('app', 'Statistics');
$this->params['breadcrumbs'][] = $this->title;

$alexaDetail = $model->getAlexaRank();
?>
<script>
    var visit_labels = 'c';
</script>


<?= Html::beginPanel(Yii::t('app','Post'), 'col-md-3 col-xs-12 col-sm-6',['panel', 'panel-default'], ['panel-heading', 'panel-status'], ['panel-body', 'panel-body-detail']) ?>
    <?= $postCount = $model->getPostCount() ?>
<?= Html::endPanel() ?>

<?= Html::beginPanel(Yii::t('app','Post views'), 'col-md-3 col-xs-12 col-sm-6',['panel', 'panel-default'], ['panel-heading', 'panel-status'], ['panel-body', 'panel-body-detail']) ?>
    <?= $postViews = $model->getPostViews() ?>
<?= Html::endPanel() ?>

<?= Html::beginPanel(Yii::t('app','Alexa global rank'), 'col-md-3 col-xs-12 col-sm-6',['panel', 'panel-default'], ['panel-heading', 'panel-status'], ['panel-body', 'panel-body-detail ltr']) ?>
    <?= $alexaDetail['global'] ?>
<?= Html::endPanel() ?>

<?= Html::beginPanel(Yii::t('app','Alexa rank in your country'), 'col-md-3 col-xs-12 col-sm-6',['panel', 'panel-default'], ['panel-heading', 'panel-status'], ['panel-body', 'panel-body-detail ltr']) ?>
    <?= $alexaDetail['country'] ?>
<?= Html::endPanel() ?>

<div class="clear"></div>

<?= Html::beginPanel(Yii::t('app','Posts detail group by categories')) ?>
<?= GridView::widget([
    'dataProvider' => $model->getPostsDetailGroupByCategories(),
    'layout' => "{items}\n{pager}",
    'columns' => [
        [
            'attribute' => 'title',
            'label' => Yii::t('app','Category title'),
        ],
        [
            'attribute' => 'count',
            'label' => Yii::t('app','Post count'),
            'format' => 'raw',
            'value' => function($model) use($postCount) {
                return  $model->count . "<div class='statistics-grade-detail'>" . Yii::t('app', '{amount}% of all posts', ['amount' => number_format(($model->count / $postCount) * 100, 2)]) . '<div>';
            },
        ],
        [
            'attribute' => 'sum',
            'label' => Yii::t('app','Post views'),
            'format' => 'raw',
            'value' => function($model) use($postViews) {
                return  $model->sum . "<div class='statistics-grade-detail'>" . Yii::t('app', '{amount}% of all views', ['amount' => number_format(($model->sum / $postViews) * 100, 2)]) . '<div>';
            },
        ],
    ],
]) ?>
<?= Html::endPanel() ?>

<?= Html::beginPanel(Yii::t('app','Top posts')) ?>
<?= GridView::widget([
    'dataProvider' => $model->getTopPosts(),
    'layout' => "{items}\n{pager}",
    'columns' => [
        [
            'attribute' => 'title',
            'format' => 'raw',
            'value' => function($model) {
                return  Html::a($model->title, ['../post/default/view', 'id' => $model->id]);
            },
        ],
        'view',

    ],
]) ?>
<?= Html::endPanel() ?>

<?= Html::beginPanel(Yii::t('app','Browsers'), 'col-md-6') ?>
        <div style="margin: 0 auto">
            <canvas id="chart_pie" height="161"/>
            <script>
                var pie_chart_data = <?= $pie_chart; ?>;
            </script>
        </div>
<?= Html::endPanel() ?>

<?= Html::beginPanel(Yii::t('app','Visitor timeline'), 'col-md-6') ?>
    <span style="padding: 10px;">
        <div id="container" style="margin: 0 auto">
            <canvas id="line" dir="rtl"></canvas>
                <script>
                    var visit_period_data = <?= $visit_period; ?>;
                </script>
        </div>
    </span>
<?= Html::endPanel() ?>
