<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
    <title><?= Html::encode($title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div style="text-align: right; direction: rtl">
        <div style="background:#f5f5f5; width:100%; font-family: Tahoma; font-size: 12px; background-color: #f1f1f1; padding: 30px 0px 30px 0px;">
            <div style="width: 600px; background-color: #ffffff; margin: 0 auto; border-radius: 2px;">
                <div style="background-color: #F68657; font-weight: bold; padding: 10px; border-radius: 2px 2px 0px 0px;">
                    <span style="color: #FFFFFF; text-decoration: none;"><?= $title ?></span>
                </div>
                <div style="text-align: justify; padding: 10px; line-height: 160%;">
                    <?= $content ?>
                </div>

                <?php if (isset($model)): ?>
                    <div style="clear: both; margin-top: 15px;"></div>
                    <div style="text-align: center">
                        <a href="<?= $siteUrl ?>post/view/<?= $model->id . '/' . urlencode($model->title) ?>.html"><?= Yii::t('app', 'Read More') ?></a>
                    </div>
                    <div style="clear: both; margin-top: 25px;"></div>
                <?php endif; ?>

                <div style="background-color: #F68657; font-weight: bold; padding: 10px; border-radius: 0px 0px 2px 2px; text-align: center">
                    <a href="http://www.developit.ir" style="color: #FFFFFF; text-decoration: none;"><?= Yii::t('app', 'Powered By Raspina CMS') ?></a>
                </div>
            </div>
            <div style="text-align: center; margin-top: 15px; font-size: 11px;">
                <a href="<?= $siteUrl ?>" style="text-decoration: none;" target="_blank"><?= $siteTitle ?></a> |
                <a href="<?= $siteUrl ?>newsletter/unsubscribe" style="text-decoration: none;" target="_blank"><?= Yii::t('app', 'Unsubscribe Newsletter') ?></a>
            </div>
        </div></div>
    <?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
