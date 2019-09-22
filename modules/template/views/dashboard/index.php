<?php
use yii\grid\GridView;
use app\components\helpers\Html;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model app\modules\template\models\Template */
?>

<?= Html::beginPanel(Yii::t('app','Templates')) ?>

    <?php foreach((array)$templates as $k => $template): ?>
    <div class="template row">
        <div class="template-detail col-md-9">
            <?php if($defaultTemplate == $k): ?>
                <?= Html::a(Yii::t('app','Default Template'), '#', [
                    'class' => 'btn btn-success'
                ]) ?>
            <?php else: ?>
                <?= Html::a(Yii::t('app', 'Select'), ['select', 'id' => $k], [
                    'data-method' => 'post',
                    'class' => 'btn btn-primary'
                ]) ?>
            <?php endif; ?>
            <br><br>
            <div class="clear"></div>
            <?= nl2br($template['description']) ?>
        </div>
        <div class="template-snapshot col-md-3">
            <img src="<?= $template['snapshot'] ?>">
        </div>
    </div>
        <hr>
    <?php endforeach; ?>

<?= Html::endPanel() ?>
