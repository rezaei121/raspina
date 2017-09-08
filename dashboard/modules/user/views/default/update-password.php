<?php

use dashboard\components\helpers\Html;
use dashboard\components\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model dashboard\modules\user\models\User */

$this->title = Yii::t('app', 'Update Password');
$this->params['breadcrumbs'][] = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = "$model->last_name $model->surname - {$model->username}";
$this->params['breadcrumbs'][] = $this->title;
?>
<?= Html::beginPanel($this->title) ?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'old_password')->passwordInput() ?>
<?= $form->field($model, 'new_password')->passwordInput() ?>
<?= $form->field($model, 'password_repeat')->passwordInput() ?>

<div class="form-group center">
    <?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

<?= Html::endPanel() ?>
