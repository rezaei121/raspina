<?php
use yii\helpers\Html;
?>

<div class="cropper-widget">
    <?= Html::activeHiddenInput($model, $widget->attribute, ['class' => 'photo-field']); ?>
    <?= Html::hiddenInput('width', $widget->width, ['class' => 'width-input']); ?>
    <?= Html::hiddenInput('height', $widget->height, ['class' => 'height-input']); ?>
    <div class="new-photo-area" style="height: <?= $widget->cropAreaHeight; ?>; width: <?= $widget->cropAreaWidth; ?>;">
        <div class="cropper-label">
            <div><?= Yii::t('jcrop', 'Drag Photo');?></div>
            <div><?= Yii::t('jcrop', 'Or');?></div>
            <div><?= Html::button(Yii::t('jcrop', 'Select Photo'),['class' => 'btn btn-primary']) ?></div>
        </div>
    </div>

    <div class="cropper-buttons">
        <?= Html::button(Yii::t('jcrop', 'Crop Photo'),['class' => 'btn btn-sm btn-success crop-photo hidden']) ?>
        <?= Html::button(Yii::t('jcrop', 'Select Another Photo'),['class' => 'btn btn-sm btn-info upload-new-photo hidden']) ?>
    </div>

    <div class="progress hidden" style="width: <?= $widget->cropAreaWidth; ?>;">
        <div class="progress-bar progress-bar-striped progress-bar-success active" role="progressbar" style="width: 0%">
            <span class="sr-only"></span>
        </div>
    </div>

    <?= Html::img(
        $model->{$widget->attribute} != ''
            ? $model->{$widget->attribute}
            : null,
        [
            'style' => 'height: ' . $widget->height . 'px; width: ' . $widget->width . 'px',
            'class' => 'thumbnail jcrop-thumbnail hide'
        ]
    ); ?>

</div>