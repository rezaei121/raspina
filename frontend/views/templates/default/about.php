<?php
//var_dump($model); exit();
use common\models\User;
use frontend\components\helpers\Raspina;
Raspina::title(Yii::t('app','About'));
?>
<div class="post-border shadow">
    <div class="panel panel-default post-panel">
        <div class="panel-body">
            <div class="post-title"><?= Yii::t('app','About') ?></div>
            <div class="post-text">
                <!-- -->
                <br>
                <?php foreach ($model as $user): ?>
                <img style="float: right; margin-left: 10px;" src="<?= User::getAvatar($user->id); ?>" width="200">
                <h4 style="font-weight: bold; font-size: 14px; margin-bottom: 6px;"><?= "{$user->last_name} {$user->surname}" ?></h4>
                <p><?= $user->about_text ?></p>
                    <div class="clear"></div>
                    <hr>
                <?php endforeach; ?>
<!--                --><?//= $about['more_text'] ?>
                <!-- -->
            </div>
        </div>
    </div>
</div>