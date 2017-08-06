<?php

use dashboard\helpers\Html;
use dashboard\components\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model dashboard\modules\user\models\User */

$this->title = Yii::t('app', 'Update Password');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => "$model->last_name $model->surname - {$model->username}", 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= Html::beginPanel($this->title) ?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'password')->passwordInput() ?>
<?= $form->field($model, 'password_repeat')->passwordInput() ?>

<div class="form-group center">
    <?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

<?= Html::endPanel() ?>
