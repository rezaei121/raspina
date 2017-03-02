<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\File */

$this->title = Yii::t('app', 'Upload File');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Files'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="file-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
