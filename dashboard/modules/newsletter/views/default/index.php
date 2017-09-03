<?php
use dashboard\components\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel dashboard\modules\newsletter\models\NewsletterSearch */
/* @var $searchModel dashboard\modules\newsletter\models\Newsletter */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Newsletters users') . ". (" . Yii::t('app', '{count} member', ['count' => $userCount]) . ")";
$this->params['breadcrumbs'][] = Yii::t('app', 'Newsletter');
?>

<?= Html::beginPanel(null, 'col-md-4 col-sm-12 col-xs-12',['panel', 'panel-default'], ['panel-heading', 'panel-status'], ['panel-body', 'panel-body-detail sub-menu']) ?>
    <a href="<?= Url::base() ?>/newsletter/default/send">
        <div class="fa fa-share"></div>
        <div class="sub-menu-title"><?= Yii::t('app', 'Send Newsletter') ?></div>
    </a>
<?= Html::endPanel() ?>

<?= Html::beginPanel(null, 'col-md-4 col-sm-12 col-xs-12',['panel', 'panel-default'], ['panel-heading', 'panel-status'], ['panel-body', 'panel-body-detail sub-menu']) ?>
    <a href="<?= Url::base() ?>/newsletter/default/logs">
        <div class="fa fa-list-alt"></div>
        <div class="sub-menu-title"><?= Yii::t('app', 'Sent newsletters') ?></div>
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
    <?= Html::beginForm(['group-actions'],'post') ?>
    <?= Html::dropDownList('action','',['delete' => Yii::t('app','Delete')],['class'=>'dropdown fa-bulk-dropdown',]) ?>
<?= Html::submitButton(Yii::t('app','Apply'), ['class' => 'btn-sm btn-primary fa-bulk-button', 'data-confirm' => Yii::t('app', 'Are you sure you want to do?')]) ?>
    <div class="fa-br"></div>
    <br>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => "{items}\n{pager}",
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                'headerOptions' => ['class'=>'fit'],
                'contentOptions' => ['class' => 'fit center'],
            ],
            [
                'attribute' => 'email',
                'value' => 'email',
            ],
            [
                'class' => \dashboard\components\grid\ActionColumn::className(),
                'headerOptions' => ['class'=>'fit'],
                'filterOptions' => ['class'=>'fit'],
                'contentOptions' => ['class' => 'action-column fit'],
                'template' => '{delete}'
            ],
        ],
    ]); ?>
    <?= Html::endForm() ?>
<?= Html::endPanel() ?>