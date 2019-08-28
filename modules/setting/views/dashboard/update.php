<?php
/* @var $this yii\web\View */
/* @var $model dashboard\modules\setting\models\Setting */

$this->title = Yii::t('app', 'Update Setting');

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Settings')];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
