<?php

use app\components\helpers\Html;
use dosamigos\tinymce\TinyMce;
use app\components\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model dashboard\modules\user\models\User */

$this->title = Yii::t('app', 'My profile');
$this->params['breadcrumbs'][] = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = "$model->last_name $model->surname - {$model->username}";
$this->params['breadcrumbs'][] = $this->title;
?>
<?= Html::beginPanel($this->title) ?>
    <div style="text-align: left">
        <?= Html::a(Yii::t('app', 'Update Avatar'), ['avatar'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Update Password'), ['update-password'], ['class' => 'btn btn-primary']) ?>
        <br>
    </div>
    <br>
    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'class' => 'form-control ltr']) ?>
        <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'class' => 'form-control ltr']) ?>
        <?= $form->field($model, 'about_text')->widget(TinyMce::className(), [
            'options' => ['rows' => 20],
            'language' => Yii::$app->params['lang'],
            'clientOptions' => [
                'content_css' => \yii\helpers\Url::to(['/web/css/tinymce.css']),
                'directionality' => Yii::$app->params['direction'],
                'entity_encoding' => "utf-8",
                'relative_urls' => false,
                'menubar' => false,
                'automatic_uploads' => true,
                'images_upload_url' => 'postAcceptor.php',
                'images_reuse_filename' => true,
                'plugins' => [
                    "advlist autolink lists link charmap visualblocks code media table contextmenu image media codesample code"
                ],
                'toolbar' => "underline italic bold styleselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | media image  table link | codesample | code"
            ]
        ]) ?>
            <div class="form-group center">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
    <?php ActiveForm::end(); ?>
<?= Html::endPanel() ?>
