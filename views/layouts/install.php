<?php
use app\assets\InstallAsset;
use app\components\widgets\Alert;
use yii\helpers\Html;
use yii\helpers\Url;

InstallAsset::register($this);
$baseAssetUrl = Yii::getAlias('@web/web/install');
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Install Raspina CMS.</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=0.9, user-scalable=no" />
    <link href="css/index.css" rel="stylesheet">
    <?= Html::csrfMetaTags() ?>
    <?php $this->head() ?>
    <script type="text/javascript">
        var base_url = '<?= Url::base() ?>';
    </script>
</head>
<body>
<?php $this->beginBody() ?>
<!-- section-1 -->
<div class="section-1">
    <div class="container">
        <div class="row v-center">
            <div class="col-md-3">
                <div class="logo">
                    <img src="<?= $baseAssetUrl ?>/img/raspina.svg">
                </div>
            </div>
            <div class="col-md-9 ">
                <div class="">
                    <h1>Install</h1>
                    <h2>Welcome To Install Raspina CMS.</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="clear"></div>
</div>
<!-- /section-1 -->

<!-- sections -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?= Alert::widget() ?>
        </div>
    </div>
</div>
<?= $content ?>
<!-- /sections -->
<!-- section-d -->
<div class="section-3 center">
    <div class="container">
        <img style="background-color: #f7f5f2; padding-left: 10px; padding-right: 10px;" src="<?= $baseAssetUrl ?>/img/developer.svg" width="80">
        <div class="line"></div>
        <div class="row" style="margin-top: 30px;">
            <div class="col-md-12 developer" style="text-align: left">
                <h4>Contact Developer</h4>
                <h5>Ehsan Rezaei.</h5>
                <h6>#ISTJ Sofware Engineer. Full Stack Developer.  CTO.</h6>
                <div>E-mail: me@de<span>blah...blah...blah :)</span>velopit.ir</div>
                <div>Blog: <a href="http://www.developit.ir">developit.ir</a></div>
            </div>
        </div>
    </div>
</div>
<!-- /section-d -->
<br><br><br>
<div class="hole">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <textarea id="db-log" readonly>Import database. please wait...</textarea>
                <div class="form-group center">
                    <br>
                    <div class="btn btn-danger install-button" id="close-db-log">CLOSE</div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
