<?php
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\About */

$this->title = Yii::t('app', 'Update');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'About'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="about-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
