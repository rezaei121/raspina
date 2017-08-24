<?php
use frontend\components\helpers\Raspina;
Raspina::title('About');
?>
<div class="post-border shadow">
    <div class="panel panel-default post-panel">
        <div class="panel-body">
            <div class="post-title"><?= Raspina::t('About') ?></div>
            <div class="post-text">
                <!-- -->
                <br>
                <?php foreach ($model as $user): ?>
                <img style="float: right; margin-left: 10px;" src="<?= $user->avatar(); ?>" width="200">
                <h4 style="font-weight: bold; font-size: 14px; margin-bottom: 6px;"><?= $user->name() ?></h4>
                <p><?= $user->about() ?></p>
                    <div class="clear"></div>
                    <hr>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>