<?php

use dashboard\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model dashboard\modules\user\models\User */

$this->title = Yii::t('app', 'Update User');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => "$model->last_name $model->surname - {$model->username}", 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= Html::beginPanel($this->title) ?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'username')->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'Username')])->label(false) ?>
<?= $form->field($model, 'last_name')->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'Last Name')])->label(false) ?>
<?= $form->field($model, 'surname')->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'Surname')])->label(false) ?>
<?= $form->field($model, 'email')->textInput(['class' => 'form-control ltr', 'maxlength' => true, 'placeholder' => Yii::t('app', 'Email')])->label(false) ?>
<?= $form->field($model, 'status')->dropDownList($model->getStatus(), ['placeholder' => Yii::t('app', 'Status')])->label(false) ?>
<?= $form->field($model, 'role')->dropDownList($model->getRols(), ['placeholder' => Yii::t('app', 'Role')])->label(false) ?>
<?= Html::a(Yii::t('app', 'Update Password'), ['update-password', 'id' => $model->id]) ?>
<div class="form-group center">

    <?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

<?= Html::endPanel() ?>
