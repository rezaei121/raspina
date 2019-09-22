<?php
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$baseAssetUrl = Yii::getAlias('@web/web/install');
?>
<?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
<div class="section-3 center" id="db-section">
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
                <?= $form->field($model, 'db_password')->passwordInput() ?>
                <?= $form->field($model, 'table_prefix')->textInput() ?>
                <br><br>
                <div class="form-group center">
                    <div class="btn btn-primary install-button disabled" id="test-connection">IMPORT DATABASE</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section-3 center" id="user-section">
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
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 're_password')->passwordInput() ?>
            </div>
        </div>
    </div>
</div>

<div class="section-3 center" id="setting-section">
    <div class="container">
        <img style="background-color: #f7f5f2; padding-left: 10px; padding-right: 10px;" src="<?= $baseAssetUrl ?>/img/computer.svg" width="80">
        <div class="line"></div>
        <div class="row" style="margin-top: 30px;">
            <div class="col-md-12" style="text-align: left">
                <h4>CMS Setting.</h4>
                <br>
                <?= $form->field($model, 'url')->textInput() ?>
                <?= $form->field($model, 'title')->textInput() ?>
                <?= $form->field($model, 'description')->textInput() ?>
                <?= $form->field($model, 'language')->dropDownList((new \app\modules\setting\models\Setting())->languageList(), ['maxlength' => true, 'class'=>'form-control ltr']) ?>
                <?= $form->field($model, 'time_zone')->widget(Select2::classname(), [
                    'data' => (new \app\modules\setting\models\Setting())->timezoneList(),
                ]); ?>
                <br><br>
                <div class="form-group center">
                    <?= Html::submitButton('INSTALL', ['class' => 'btn btn-primary install-button']) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
