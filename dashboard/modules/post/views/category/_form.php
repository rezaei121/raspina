<?php
use yii\helpers\Html;
use dashboard\components\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model dashboard\modules\post\models\Category */
/* @var $form dashboard\components\widgets\ActiveForm */
?>
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'placeholder' => $model->isNewRecord ? Yii::t('app', 'Title') : '']) ?>

    <?php if(!$model->isNewRecord): ?>
        <div class="form-group center">
            <?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-primary']) ?>
        </div>
    <?php endif; ?>

    <?php ActiveForm::end(); ?>
