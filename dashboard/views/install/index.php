<?php
$this->title = 'Install';
?>

<div class="col-md-12 " id="welcome" style="text-align: center">
    <div class="welcome">Welcome</div>
    <a href="../requirements.php" class="requirements" target="_blank">See Requirements</a>
    <a href="<?= \yii\helpers\Url::to(['/install/step1']) ?>" class="raspina">Install Raspina CMS</a>
    <div class="clear" style="margin-bottom: 65px;"></div>
    <img class="dashboard" src="<?= Yii::getAlias('@web/web/img') ?>/dashboard.png">
</div>