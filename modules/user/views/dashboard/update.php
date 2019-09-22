<?php

use app\components\helpers\Html;
use app\components\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model dashboard\modules\user\models\User */

$this->title = Yii::t('app', 'Update User');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => "$model->last_name $model->surname - {$model->username}", 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= Html::beginPanel($this->title) ?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'email')->textInput(['class' => 'form-control ltr', 'maxlength' => true]) ?>
<?= $form->field($model, 'status')->dropDownList($model->getStatus()) ?>
<?= $form->field($model, 'role')->dropDownList($model->getRols()) ?>
<?= Html::a(Yii::t('app', 'Update Password'), ['update-user-password', 'id' => $model->id]) ?>
<div class="form-group center">

    <?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

<?= Html::endPanel() ?>
