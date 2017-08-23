<?php
use yii\widgets\ActiveForm ;
use yii\helpers\Html;
use developit\captcha\Captcha ;
use frontend\components\helpers\Raspina;

Raspina::title($model['title']);
?>
<div class="post-border shadow">
    <div class="panel panel-default post-panel">
        <div class="panel-body">
            <div class="post-title"><?= Html::a($model['title'],[0 => 'post/view','id' => $model['id'],'title' => $model['title']]) ?></div>
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
                <?= Html::a("{$model['last_name']} {$model['surname']}", ['/user/about', 'username' => $model['username']]) ?>
			</span>
			<span class="post-detail">
				<span class="fa fa-calendar"></span>
                <?=  Yii::$app->date->asDatetime($model['created_by']); ?>
			</span>
			<span class="post-detail">
				<span class="fa fa-comment-o"></span>
                <?= $model['comment_count'] ?>
			</span>
			<span class="post-detail">
				<span class="fa fa-eye "></span>
                <?= $model['view'] ?>
			</span>
            <div class="clear"></div>
            <!-- -->
            <div class="post-text">
                <?= $model['short_text']?>
                <br>
                <?= $model['more_text'] ?>
                <?php if($model['updated_by']): ?>
                <span style="font-style: italic">این مطلب آخرین بار در تاریخ  <?=  Yii::$app->date->asDatetime($model['updated_by']) ?>  ویرایش شده است.</span>
                <?php endif ?>
                <?php if($model['tags']): ?>
                <hr class="more-hr">
                <div class="post-tags"><span class="fa fa-tags"></span>
                    <?php foreach ($model['tags'] as $tag): ?>
                        <a href="<?= $this->params['url'] ?>site/index/tag/<?= $tag ?>"><?= $tag ?></a><delimiter>،</delimiter>
                    <?php endforeach ?>
                </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>
<?php if($postRelated): ?>
    <div class="post-border shadow">
        <div class="panel panel-default post-panel">
            <div class="panel-body">
                <div class="post-title">مرتبط ها</div>
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

<?php if($comments): ?>
<div class="post-border shadow">
    <div class="panel panel-default post-panel">
        <div class="panel-body">
            <div class="post-title">نظرات</div>
            <div class="post-text">
                <!-- -->
                    <?php foreach($comments as $c): ?>
                        <div class="comment-title"><span><?= $c['name'] ?></span> در تاریخ <span><?= Date::widget(['value' => $c['created_by']]) ?></span> نوشته: </div>
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

<?php if($model['enable_comments']): ?>
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

