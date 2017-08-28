<?php

use common\widgets\Alert;
use dashboard\components\helpers\Html;
use dashboard\modules\post\models\Post;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

$this->title = 'Blog setting';
?>

<div class="centered">
    <?= Html::beginPanel($this->title) ?>
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'url')->textInput(['maxlength' => true, 'class'=>'form-control ltr']) ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'language')->dropDownList($model->languageList(), ['maxlength' => true, 'class'=>'form-control ltr']) ?>
    <?= $form->field($model, 'time_zone')->dropDownList($model->timezoneList(), ['maxlength' => true, 'class'=>'form-control ltr']) ?>
    <div class="form-group center">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
    <?= Html::endPanel() ?>
</div>
