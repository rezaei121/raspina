<?php
use app\components\helpers\Html;
use app\components\widgets\ActiveForm;
use developit\jcrop\Jcrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model dashboard\modules\user\models\User */

$this->title = Yii::t('app', 'Avatar');
$this->params['breadcrumbs'][] = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = "$model->last_name $model->surname - {$model->username}";
$this->params['breadcrumbs'][] = $this->title;
?>

<?= Html::beginPanel($this->title) ?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<?php echo $form->field($model, 'avatar')->widget(Jcrop::className(), [
    'uploadUrl' => Url::toRoute('/user/default/myavatar'),
    'width' => 400,
    'height' => 400,
]) ?>
<?php ActiveForm::end(); ?>
<?= Html::endPanel() ?>


