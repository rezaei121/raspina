<?php
use dashboard\components\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model dashboard\modules\newsletter\models\NewsletterLog */
/* @var $searchModel dashboard\modules\newsletter\models\Newsletter */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Sent newsletters');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Newsletter'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= Html::beginPanel(null, 'col-md-4 col-sm-12 col-xs-12',['panel', 'panel-default'], ['panel-heading', 'panel-status'], ['panel-body', 'panel-body-detail sub-menu']) ?>
    <a href="<?= Url::base() ?>/newsletter/default/send">
        <div class="fa fa-share"></div>
        <div class="sub-menu-title"><?= Yii::t('app', 'Send Newsletter') ?></div>
    </a>
<?= Html::endPanel() ?>

<?= Html::beginPanel(null, 'col-md-4 col-sm-12 col-xs-12',['panel', 'panel-default'], ['panel-heading', 'panel-status'], ['panel-body', 'panel-body-detail sub-menu']) ?>
    <a href="<?= Url::base() ?>/newsletter/default/index">
        <div class="fa fa-users"></div>
        <div class="sub-menu-title"><?= Yii::t('app', 'Members') ?></div>
    </a>
<?= Html::endPanel() ?>

<?= Html::beginPanel(null, 'col-md-4 col-sm-12 col-xs-12',['panel', 'panel-default'], ['panel-heading', 'panel-status'], ['panel-body', 'panel-body-detail sub-menu']) ?>
    <a href="<?= Url::base() ?>/newsletter/default/template">
        <div class="fa fa-file-code-o"></div>
        <div class="sub-menu-title"><?= Yii::t('app', 'Template') ?></div>
    </a>
<?= Html::endPanel() ?>

<div class="clear"></div>

<?= Html::beginPanel($this->title) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "{items}\n{pager}",
        'columns' => [
            [
                'attribute' => 'title',
                'format' => 'raw',
                'value' => function($model){
                    return  "
                            <div class='newsletter-log-container'>
                                <a href='#' class='newsletter-log-title'>{$model->title}</a>
                                <div class='newsletter-log-detail'>{$model->text}</div>
                            </div>
                            ";
                },
            ],
            [
                'attribute' => 'sent_at',
                'value' => function($model){
                    return  Yii::$app->date->asDateTime($model->sent_at);
                },
                'headerOptions' => ['class'=>'auto-fit'],
                'filterOptions' => ['class'=>'auto-fit'],
                'contentOptions' => ['class' => 'auto-fit center ltr'],
            ],
        ],
    ]); ?>
    <?= Html::endForm() ?>
<?= Html::endPanel() ?>