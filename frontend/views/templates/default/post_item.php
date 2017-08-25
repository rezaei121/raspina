<?php
use yii\helpers\Html;
use frontend\components\helpers\Raspina;
/* @var $model frontend\models\Post */
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
                        <?= Html::a($pc['category']['title'],[0 => 'site/index','category' => $pc['category']['id'],'title' => $pc['category']['title']]) ?><delimiter>،</delimiter>
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
                <br>
                <?= $model->more_text ?>
                <?php if($updaterAuthor = $model->updaterAuthor()): ?>
                    <span style="font-style: italic"><?= Raspina::t('This post was last updated on {date} by {user}.', [
                            'date' => Raspina::date($model->updated_at),
                            'user' => $updaterAuthor
                        ]) ?></span>
                <?php endif ?>
                <?php if($tags = $model->tags()): ?>
                    <hr class="more-hr">
                    <div class="post-tags"><span class="fa fa-tags"></span>
                        <?php foreach ($tags as $tag): ?>
                            <?= Html::a($tag, ['/site/index', 'tag' => $tag]) ?>,
                        <?php endforeach ?>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>


