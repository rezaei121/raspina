<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Post */

$this->title = Yii::t('app', 'Account');
$this->params['breadcrumbs'][] = ['label' => $this->title];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="post-update">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><?= $this->title ?></div>
            <div class="panel-body">
                <div class="link-update">

                    <div class="link-form">

                        <?php $form = ActiveForm::begin(); ?>

                        <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'dir' => 'ltr']) ?>
                        <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'dir' => 'ltr']) ?>

                        <div class="form-group">
                            <?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-primary']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
