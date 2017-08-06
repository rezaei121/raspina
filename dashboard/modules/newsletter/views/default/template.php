<?php
use dashboard\helpers\Html;
use dashboard\components\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model dashboard\modules\newsletter\models\Newsletter */

$this->title = Yii::t('app', 'Template');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Newsletter'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= Html::beginPanel($this->title) ?>
    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'template')->textarea(
    [
        'maxlength' => true,
        'rows' => '20',
        'class' => 'form-control ltr'
    ]) ?>
    <?= Html::a(Yii::t('app', 'Restore default template.'), '#',['class' => 'restore-default-template']) ?>
    <div class="form-group center">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
<?= Html::endPanel() ?>