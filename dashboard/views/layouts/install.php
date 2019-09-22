<?php
use dashboard\assets\InstallAsset;
use yii\helpers\Html;
use yii\helpers\Url;

InstallAsset::register($this);

?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta name="robots" content="noindex">
        <meta name="googlebot" content="noindex">
        <?= Html::csrfMetaTags() ?>
        <title><?= Yii::t('app', 'Raspina') ?> - <?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>
        <div class="main-content">
            <?= $content ?>
        </div>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>