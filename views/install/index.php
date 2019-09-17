<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$baseAssetUrl = Yii::getAlias('@web/web/install');
?>
<?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
<div class="section-3 center">
    <div class="container">
        <img style="background-color: #f7f5f2; padding-left: 10px; padding-right: 10px;" src="<?= $baseAssetUrl ?>/img/database.svg" width="80">
        <div class="line"></div>
        <div class="row" style="margin-top: 30px;">
            <div class="col-md-12 developer" style="text-align: left">
                <h4>Database Config.</h4>
                <br>
                <?= $form->field($model, 'dbms')->textInput() ?>
                <?= $form->field($model, 'db_host')->textInput() ?>
                <?= $form->field($model, 'db_name')->textInput() ?>
                <?= $form->field($model, 'db_username')->textInput() ?>
                <?= $form->field($model, 'db_password')->textInput() ?>
                <?= $form->field($model, 'table_prefix')->textInput() ?>
            </div>
        </div>
    </div>
</div>

<div class="section-3 center">
    <div class="container">
        <img style="background-color: #f7f5f2; padding-left: 10px; padding-right: 10px;" src="<?= $baseAssetUrl ?>/img/user.svg" width="80">
        <div class="line"></div>
        <div class="row" style="margin-top: 30px;">
            <div class="col-md-12 developer" style="text-align: left">
                <h4>Admin Information.</h4>
                <br>
                <?= $form->field($model, 'last_name')->textInput() ?>
                <?= $form->field($model, 'surname')->textInput() ?>
                <?= $form->field($model, 'username')->textInput() ?>
                <?= $form->field($model, 'email')->textInput() ?>
                <?= $form->field($model, 'password')->textInput() ?>
                <?= $form->field($model, 're_password')->textInput() ?>
            </div>
        </div>
    </div>
</div>

<div class="section-3 center">
    <div class="container">
        <img style="background-color: #f7f5f2; padding-left: 10px; padding-right: 10px;" src="<?= $baseAssetUrl ?>/img/computer.svg" width="80">
        <div class="line"></div>
        <div class="row" style="margin-top: 30px;">
            <div class="col-md-12 developer" style="text-align: left">
                <h4>CMS Setting.</h4>
                <br>
                <?= $form->field($model, 'url')->textInput() ?>
                <?= $form->field($model, 'title')->textInput() ?>
                <?= $form->field($model, 'description')->textInput() ?>
                <?= $form->field($model, 'language')->textInput() ?>
                <?= $form->field($model, 'time_zone')->textInput() ?>
                <br><br>
                <div class="form-group center">
                    <?= Html::submitButton('INSTALL', ['class' => 'btn btn-primary install-button']) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
