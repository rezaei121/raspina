<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading"><?= $model->title ?></div>
        <div class="panel-body">

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model dashboard\models\Link */

$this->title = Yii::t('app', 'Update');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Links'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="link-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

        </div>
    </div>
</div>
