<?php

use app\components\helpers\Html;
use app\components\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model dashboard\modules\user\models\User */

$this->title = Yii::t('app', 'Create User');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= Html::beginPanel($this->title) ?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'email')->textInput(['class' => 'form-control ltr', 'maxlength' => true]) ?>
<?= $form->field($model, 'password')->passwordInput() ?>
<?= $form->field($model, 'password_repeat')->passwordInput() ?>
<?= $form->field($model, 'status')->dropDownList($model->getStatus()) ?>
<?= $form->field($model, 'role')->dropDownList($model->getRols()) ?>

<div class="form-group center">
    <?= Html::submitButton(Yii::t('app', 'Create'), ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>

<?= Html::endPanel() ?>
