<?php

use dashboard\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model dashboard\modules\user\models\User */

$this->title = Yii::t('app', 'Create User');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= Html::beginPanel($this->title) ?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'username')->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'Username')])->label(false) ?>
<?= $form->field($model, 'last_name')->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'Last Name')])->label(false) ?>
<?= $form->field($model, 'surname')->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'Surname')])->label(false) ?>
<?= $form->field($model, 'email')->textInput(['class' => 'form-control ltr', 'maxlength' => true, 'placeholder' => Yii::t('app', 'Email')])->label(false) ?>
<?= $form->field($model, 'password')->passwordInput(['placeholder' => Yii::t('app', 'Password')])->label(false) ?>
<?= $form->field($model, 'password_repeat')->passwordInput(['placeholder' => Yii::t('app', 'Repeat Password')])->label(false) ?>
<?= $form->field($model, 'status')->dropDownList($model->getStatus(), ['placeholder' => Yii::t('app', 'Status')])->label(false) ?>
<?= $form->field($model, 'role')->dropDownList($model->getRols(), ['placeholder' => Yii::t('app', 'Role')])->label(false) ?>

<div class="form-group center">
    <?= Html::submitButton(Yii::t('app', 'Create'), ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>

<?= Html::endPanel() ?>
