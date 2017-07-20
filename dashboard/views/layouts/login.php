<?php
use dashboard\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use common\widgets\Alert;

AppAsset::register($this);

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
    <link type="text/css" rel="stylesheet" href="https://cdn.rawgit.com/rastikerdar/sahel-font/v1.0.0-alpha6/dist/font-face.css">
    <link type="text/css" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
    <?php $this->head() ?>
    <script type="text/javascript">
        var base_url = '<?= Url::base() ?>';
        var modules_name = '<?= $modules_id ?>';
        var controller_name = '<?= $controller_id ?>';
        var action_name = '<?= $action_id ?>';
    </script>
</head>
<body>
<div class="container">
    <div class="row">
        <!-- main start -->
        <div class="col-md-4 col-md-offset-4 col-login">
            <div class="panel panel-default">
                <div class="login-head">
                    <div class="login-top-text"><?= $this->title ?></div>
                    <span class="fa fa-lock login-lock"></span>
                </div>
                <div class="panel-body">
<!-- -->
                    <?php $this->beginBody() ?>
                    <?= Alert::widget() ?>
                    <?= $content ?>
                    <?php $this->endBody() ?>
<!-- -->
                </div>
            </div>
        </div>
        <!-- main end -->
    </div>
</div>
</body>

</html>
<?php $this->endPage() ?>