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

<?= Html::beginPanel($this->title, 'col-md-12') ?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<?php
echo $form->field($model, 'avatar')->widget(\bilginnet\cropper\Cropper::className(), [
    /*
     * elements of this widget
     *
     * buttonId          = #cropper-select-button-$uniqueId
     * previewId         = #cropper-result-$uniqueId
     * modalId           = #cropper-modal-$uniqueId
     * imageId           = #cropper-image-$uniqueId
     * inputChangeUrlId  = #cropper-url-change-input-$uniqueId
     * closeButtonId     = #close-button-$uniqueId
     * cropButtonId      = #crop-button-$uniqueId
     * browseInputId     = #cropper-input-$uniqueId // fileinput in modal
    */
    'uniqueId' => 'image_cropper', // will create automaticaly if not set

    // you can set image url directly
    // you will see this image in the crop area if is set
    // default null
    'imageUrl' => null,

    'cropperOptions' => [
        'width' => 200, // must be specified
        'height' => 200, // must be specified

        // optional
        // url must be set in update action
        'preview' => [
            'url' => Yii::getAlias('@web') . '/web/img/picture.png', // (!empty($model->image)) ? Yii::getAlias('@uploadUrl/'.$model->image) : null
//            'width' => 128, // must be specified // you can set as string '100%'
//            'height' => 128, // must be specified // you can set as string '100px'
        ],

        // optional // default following code
        // you can customize
        'buttonCssClass' => 'btn btn-primary',

        // optional // defaults following code
        // you can customize
        'icons' => [
            'browse' => '<i class="fa fa-image"></i>',
            'crop' => '<i class="fa fa-crop"></i>',
            'close' => '<i class="fa fa-crop"></i>',
            'zoom-out' => '<i class="fa fa-search-minus"></i>',
            'rotate-left' => '<i class="fa fa-rotate-left"></i>',
            'rotate-right' => '<i class="fa fa-rotate-right"></i>',
            'flip-horizontal' => '<i class="fa fa-arrows-h"></i>',
            'flip-vertical' => '<i class="fa fa-arrows-v"></i>',
            'move-left' => '<i class="fa fa-arrow-left"></i>',
            'move-right' => '<i class="fa fa-arrow-right"></i>',
            'move-up' => '<i class="fa fa-arrow-up"></i>',
            'move-down' => '<i class="fa fa-arrow-down"></i>',
        ]
    ],

    // optional // defaults following code
    // you can customize
    'label' => 'Select a photo from your computer',

    // optional // default following code
    // you can customize
    'template' => '<div class="center">{preview}<br>{button}</div>',

]);
?>
<div class="form-group">
    <?= \yii\helpers\Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
</div>
<?php ActiveForm::end(); ?>
<?= Html::endPanel() ?>


