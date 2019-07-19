<?php
use yii\helpers\Html;
use app\components\helpers\Raspina;
?>
<div class="post-border shadow">
    <div class="panel panel-default post-panel">
        <div class="panel-body">
            <div class="post-title">
                <a href="<?= $model->url() ?>"><?= $model->title ?></a>
            </div>
            <!-- -->
            <?php if($postCategories = $model->categories()): ?>
                <span class="post-detail">
					<span class="fa fa-list"></span>
                    <?php foreach ($postCategories as $pc): ?>
                        <?= Html::a($pc['category']['title'],[0 => 'index','category' => $pc['category']['id'],'title' => $pc['category']['slug']]) ?>،
                    <?php endforeach ?>
				</span>
            <?php endif ?>
            <span class="post-detail">
				<span class="fa fa-user"></span>
                <a href="<?= $model->authorUrl(); ?>"><?= $model->author(); ?></a>
			</span>
            <span class="post-detail">
				<span class="fa fa-calendar"></span>
                <?= Raspina::date($model->created_at) ?>
			</span>
            <span class="post-detail">
				<span class="fa fa-comment-o"></span>
                <?= $model->comment_count ?>
			</span>
            <span class="post-detail">
				<span class="fa fa-eye "></span>
                <?= $model->view ?>
			</span>
            <div class="clear"></div>
            <!-- -->
            <div class="post-text">
                <?= $model->short_text?>
                <?php if($model->more_text): ?>
                    <hr class="more-hr">
                    <a href="<?= $model->url() ?>" class="button more"><?= Yii::t('app', 'More') ?></a>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>


