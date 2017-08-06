<?php
use dashboard\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model dashboard\modules\contact\models\Contact */

$this->title = Yii::t('app', 'View contact');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contacts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= Html::beginPanel(Yii::t('app','Status'), 'col-md-2 col-sm-4 col-xs-12', null, ['panel-heading', 'panel-status'], ['panel-body', 'panel-body-detail']) ?>
<?php
    $statusList = $model->getStatusList();
    echo $statusList[$model->status];
?>
<?= Html::endPanel() ?>

<?= Html::beginPanel(Yii::t('app','Created At'), 'col-md-2 col-sm-4 col-xs-12', null, ['panel-heading', 'panel-status'], ['panel-body', 'panel-body-detail ltr']) ?>
<?= Yii::$app->date->asDatetime($model->created_at) ?>
<?= Html::endPanel() ?>

<?= Html::beginPanel(Yii::t('app','Sender'), 'col-md-2 col-sm-4 col-xs-12', null, ['panel-heading', 'panel-status'], ['panel-body', 'panel-body-detail']) ?>
<?= $model->name ?>
<?= Html::endPanel() ?>

<?= Html::beginPanel(Yii::t('app','Email'), 'col-md-2 col-sm-4 col-xs-12', null, ['panel-heading', 'panel-status'], ['panel-body', 'panel-body-detail']) ?>
<?= $model->email ?>
<?= Html::endPanel() ?>

<?= Html::beginPanel(Yii::t('app','Site'), 'col-md-2 col-sm-4 col-xs-12', null, ['panel-heading', 'panel-status'], ['panel-body', 'panel-body-detail']) ?>
<?= Html::a($model->site,$model->site,['target' => '_blank']) ?>
<?= Html::endPanel() ?>

<?= Html::beginPanel(Yii::t('app','IP'), 'col-md-2 col-sm-4 col-xs-12', null, ['panel-heading', 'panel-status'], ['panel-body', 'panel-body-detail']) ?>
<?= $model->ip ?>
<?= Html::endPanel() ?>

<div class="clear"></div>

<?= Html::beginPanel(Yii::t('app', 'Message')) ?>
<?= Html::actionButtons($model, ['delete']) ?>
<?= nl2br($model->message) ?>
<?= Html::endPanel() ?>
