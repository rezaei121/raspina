<?php
use dashboard\components\helpers\Html;

/* @var $this yii\web\View */
/* @var $model dashboard\modules\post\models\Category */

$this->title = Yii::t('app', 'Update Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Posts'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
$this->params['breadcrumbs'][] = ['label' => $model->title];
?>
<?= Html::beginPanel($this->title) ?>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
<?= Html::endPanel() ?>