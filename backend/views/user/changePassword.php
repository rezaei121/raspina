<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Link */

$this->title = Yii::t('app', 'Change Password');
//$this->params['breadcrumbs'][] = Yii::t('app', 'Change Password');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User')];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading"><?= $this->title ?></div>
        <div class="panel-body">
            <div class="link-update">

                <div class="link-form">

                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'old_password')->passwordInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'new_password')->passwordInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'repeat_password')->passwordInput(['maxlength' => true]) ?>

                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-primary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>

            </div>
        </div>
    </div>
</div>
