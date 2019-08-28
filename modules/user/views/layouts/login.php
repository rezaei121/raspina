<?php
use app\assets\DashboardAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use app\components\widgets\Alert;

DashboardAsset::register($this);

$modules_id = Yii::$app->controller->module->id;
$controller_id = Yii::$app->controller->id;
$action_id = Yii::$app->controller->action->id;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?= Html::csrfMetaTags() ?>
    <title>رسپینا - <?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <script type="text/javascript">
        var base_url = '<?= Url::base() ?>';
        var modules_name = '<?= $modules_id ?>';
        var controller_name = '<?= $controller_id ?>';
        var action_name = '<?= $action_id ?>';
    </script>
</head>
<body class="login-body">
<?php $this->beginBody() ?>

<div class="container">
    <div class="row">
        <!-- main start -->
        <div class="col-md-4 col-md-offset-4 login-form" style="margin-top: 50px;">
                    <div class="login-title">
                        <?= Yii::t('app', 'Raspina') ?>
                        <span><?= Yii::t('app', '2.3.5') ?></span>
                    </div>
                    <?= Alert::widget() ?>
                    <?= $content ?>
        </div>
        <!-- main end -->
    </div>
</div>
<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>