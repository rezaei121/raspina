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
            <?php if($postCategories): ?>
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
<!--                --><?php //if($post['tags']): ?>
<!--                <hr class="more-hr">-->
<!--                <div class="post-tags"><span class="fa fa-tags"></span>-->
<!--                    --><?php //foreach ($post['tags'] as $tag): ?>
<!--                        <a href="--><?//= $this->params['url'] ?><!--site/index/tag/--><?//= $tag ?><!--">--><?//= $tag ?><!--</a><delimiter>،</delimiter>-->
<!--                    --><?php //endforeach ?>
<!--                </div>-->
<!--                --><?php //endif ?>
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
                    <?php var_dump($postRelated); exit(); ?>
                    <?php foreach ($postRelated as $related): ?>
                        <?= Html::a($related['title'],[0 => 'post/view','id' => $related['id'],'title' => $related['title']]) ?><br>
                    <?php endforeach ?>
                    <!-- -->
                </div>
            </div>
        </div>
    </div>
<?php endif ?>

<?php if($comments): ?>
<div class="post-border shadow">
    <div class="panel panel-default post-panel">
        <div class="panel-body">
            <div class="post-title">نظرات</div>
            <div class="post-text">
                <!-- -->
                    <?php foreach($comments as $c): ?>
                        <div class="comment-title"><span><?= $c['name'] ?></span> در تاریخ <span><?= Raspina::date($c['created_by']) ?></span> نوشته: </div>
                        <div class="comment-text"><?= nl2br($c['text']) ?></div>
                        <?php if($c['reply_text']): ?>
                            <div class="comment-reply"><span>پاسخ مدیر: </span><br> <?= nl2br($c['reply_text']) ?></div>
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
            <div class="post-title">ارسال نظر</div>
            <div class="post-text">
<!-- -->
                <?php $form = ActiveForm::begin() ?>
                    <?= $form->field($commentModel,'name')->textInput(['maxlength' => true,'class' => 'input margin-17','placeholder' => 'نام']) ?>
                    <?= $form->field($commentModel,'email')->textInput(['maxlength' => true,'class' => 'input margin-17','placeholder' => 'ایمیل','dir' => 'ltr']) ?>
                    <?= $form->field($commentModel,'text')->textArea(['rows' => '6' ,'class' => 'input margin-17','placeholder' => 'متن...']) ?>
                    <?= $form->field($commentModel,'captcha')->widget(Captcha::className(),['template' => '<div class="captcha-img">{image}</div><div class="captcha-txt">{input}</div>']) ?>

                    <?= Html::submitButton('ارسال نظر',['class' => 'submit']) ?>
                <?php ActiveForm::end() ?>
<!-- -->
            </div>
        </div>
    </div>
</div>
<?php endif ?>

