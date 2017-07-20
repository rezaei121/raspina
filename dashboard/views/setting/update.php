<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model dashboard\models\Setting */

$this->title = Yii::t('app', 'Update Setting');

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Settings')];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="setting-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
