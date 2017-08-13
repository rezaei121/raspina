<?php
use frontend\helpers\Raspina;
Raspina::title(Yii::t('app','About Me'));
?>
<div class="post-border shadow">
    <div class="panel panel-default post-panel">
        <div class="panel-body">
            <div class="post-title"><?= Yii::t('app','About Me') ?></div>
            <div class="post-text">
                <!-- -->
                <br>
                <?= $about['more_text'] ?>
                <!-- -->
            </div>
        </div>
    </div>
</div>