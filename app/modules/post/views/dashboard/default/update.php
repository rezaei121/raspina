<?php
/* @var $model dashboard\modules\post\models\Post */

$this->title = Yii::t('app', 'Update Post');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>
