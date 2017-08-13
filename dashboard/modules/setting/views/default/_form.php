<?php

use dashboard\components\helpers\Html;
use dashboard\components\widgets\ActiveForm;
use dashboard\modules\post\models\Post;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model dashboard\modules\setting\models\Setting */
/* @var $form dashboard\components\widgets\ActiveForm */
?>
<?= Html::beginPanel($this->title) ?>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true, 'class'=>'form-control ltr']) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?php
    $keywords = Post::convertToAssociativeArray($model->keyword);
    echo Select2::widget([
        'name' => 'keyword',
        'id' => 'setting_keywords',
        'value' => $keywords,
        'class' => 'form-control',
        'data' => $keywords,
        'options' => ['multiple' => true],
        'pluginOptions' => [
            'tags' => true,
            'tokenSeparators' => [','],
            'maximumInputLength' => 100
        ],
    ]);
    ?>

    <?= $form->field($model, 'page_size')->textInput(['dir'=>'ltr']) ?>

    <?= $form->field($model, 'language')->dropDownList($model->languageList(), ['maxlength' => true, 'class'=>'form-control ltr']) ?>
    <?= $form->field($model, 'time_zone')->dropDownList($model->timezoneList(), ['maxlength' => true, 'class'=>'form-control ltr']) ?>

    <?= $form->field($model, 'page_size')->textInput() ?>

    <?= $form->field($model, 'date_format')->dropDownList($model->dateTimeFormats(), ['class'=>'form-control ltr'])?>

    <div class="form-group center">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

<?= Html::endPanel() ?>
