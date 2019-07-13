<?php
use dashboard\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\components\widgets\Alert;
?>
<div style="text-align: right; direction: rtl">
    <div style="background:#f5f5f5; width:100%; font-family: Tahoma; font-size: 12px; background-color: #f1f1f1; padding: 30px 0px 30px 0px;">
        <div style="width: 600px; background-color: #ffffff; margin: 0 auto; border-radius: 2px;">
            <div style="background-color: #F68657; font-weight: bold; padding: 10px; border-radius: 2px 2px 0px 0px;">
                <a href="#" target="_blank" style="color: #FFFFFF; text-decoration: none;"><?= $model->title ?></a>
            </div>
            <div style="text-align: justify; padding: 10px; line-height: 160%;">
                <?= $model->short_text ?>
            </div>
            <div style="clear: both; margin-top: 15px;"></div>
            <div style="text-align: center">
            <?php Html::a($model->title,['post/view','id' => $model->id,'title' => $model->title, 'style' => 'color: #FFFFFF; text-decoration: none; background-color: #F6B352; padding: 10px 20px 10px 20px;']); ?>
            <a href="#" target="_blank" style=""><?= Yii::t('app', 'Read More') ?></a>
            </div>
            <div style="clear: both; margin-top: 25px;"></div>
            <div style="background-color: #F68657; font-weight: bold; padding: 10px; border-radius: 0px 0px 2px 2px; text-align: center">
                <a href="#" style="color: #FFFFFF; text-decoration: none;"><?= Yii::t('app', 'Powered By Raspina CMS') ?></a>
            </div>
        </div>
        <div style="text-align: center; margin-top: 15px;"><a href="#" style="text-decoration: none;" target="_blank"><?= Yii::t('app', 'Unsubscribe Newsletter') ?></a></div>
    </div></div>