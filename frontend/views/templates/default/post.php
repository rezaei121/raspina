<?php
use yii\widgets\ActiveForm ;
use yii\helpers\Html;
use developit\captcha\Captcha ;
use frontend\components\helpers\Raspina;

/* @var $post frontend\models\Post */

Raspina::title($post->title);
//var_dump($post); exit();
?>
<div class="post-border shadow">
    <div class="panel panel-default post-panel">
        <div class="panel-body">
            <div class="post-title">
                <a href="<?= $post->url() ?>"><?= $post->title ?></a>
            </div>
            <!-- -->
            <?php if($postCategories = $post->categories()): ?>
                <span class="post-detail">
					<span class="fa fa-list"></span>
                    <?php foreach ($postCategories as $pc): ?>
						<?= Html::a($pc['category']['title'],[0 => 'site/index','category' => $pc['category']['id'],'title' => $pc['category']['title']]) ?><delimiter>،</delimiter>
                    <?php endforeach ?>
				</span>
            <?php endif ?>
            <span class="post-detail">
				<span class="fa fa-user"></span>
                <a href="<?= $post->authorUrl(); ?>"><?= $post->author(); ?></a>
			</span>
			<span class="post-detail">
				<span class="fa fa-calendar"></span>
                <?= Raspina::date($post->created_at) ?>
			</span>
			<span class="post-detail">
				<span class="fa fa-comment-o"></span>
                <?= $post->comment_count ?>
			</span>
			<span class="post-detail">
				<span class="fa fa-eye "></span>
                <?= $post->view ?>
			</span>
            <div class="clear"></div>
            <!-- -->
            <div class="post-text">
                <?= $post->short_text?>
                <br>
                <?= $post->more_text ?>
                <?php if($updaterAuthor = $post->updaterAuthor()): ?>
                <span style="font-style: italic"><?= Raspina::t('This post was last updated on {date} by {user}.', [
                        'date' => Raspina::date($post->updated_at),
                        'user' => $updaterAuthor
                    ]) ?></span>
                <?php endif ?>
                <?php if($tags = $post->tags()): ?>
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
<?php if($postRelated = $post->related()): ?>
    <div class="post-border shadow">
        <div class="panel panel-default post-panel">
            <div class="panel-body">
                <div class="post-title"><?= Raspina::t('Related'); ?></div>
                <div class="post-text">
                    <!-- -->
                    <?php foreach ($postRelated as $related): ?>
                        <?= Html::a($related['title'],[0 => 'post/view','id' => $related['id'],'title' => $related['title']]) ?><br>
                    <?php endforeach ?>
                    <!-- -->
                </div>
            </div>
        </div>
    </div>
<?php endif ?>

<?php if($comments = $post->comments()): ?>
<div class="post-border shadow">
    <div class="panel panel-default post-panel">
        <div class="panel-body">
            <div class="post-title"><?= Raspina::t('Comments') ?></div>
            <div class="post-text">
                <!-- -->
                    <?php foreach($comments as $comment): ?>
                        <div class="comment-title"><?= Raspina::t('{name} at {date} says:', [
                                'name' => $comment->name,
                                'date' => Raspina::date($comment->created_at)
                            ]) ?></div>
                        <div class="comment-text"><?= nl2br($comment->text) ?></div>
                        <?php if($comment->reply_text): ?>
                            <div class="comment-reply"><span><?= Raspina::t('reply {user}:', ['user' => $comment->createdBy->last_name]) ?></span><br> <?= nl2br($comment->reply_text) ?></div>
                        <?php endif ?>
                        <hr class="more-hr">
                    <?php endforeach ?>
                <!-- -->
            </div>
        </div>
    </div>
</div>
<?php endif ?>

<?php if($post['enable_comments']): ?>
<div class="post-border shadow">
    <div class="panel panel-default post-panel">
        <div class="panel-body">
            <div class="post-title"><?= Raspina::t('Leave a comments')?></div>
            <div class="post-text">
<!-- -->
                <?php $form = ActiveForm::begin() ?>
                    <?= $form->field($commentModel,'name')->textInput(['maxlength' => true,'class' => 'input margin-17','placeholder' => Raspina::t('Name')]) ?>
                    <?= $form->field($commentModel,'email')->textInput(['maxlength' => true,'class' => 'input margin-17','placeholder' => Raspina::t('Email'),'dir' => 'ltr']) ?>
                    <?= $form->field($commentModel,'text')->textArea(['rows' => '6' ,'class' => 'input margin-17','placeholder' => Raspina::t('Comment')]) ?>
                    <?= $form->field($commentModel,'captcha')->widget(Captcha::className()) ?>

                    <?= Html::submitButton(Raspina::t('Send'),['class' => 'submit']) ?>
                <?php ActiveForm::end() ?>
<!-- -->
            </div>
        </div>
    </div>
</div>
<?php endif ?>

