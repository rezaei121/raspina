<?php use yii\helpers\Html; ?>
<div class="post-border shadow">
    <div class="panel panel-default post-panel">
        <div class="panel-body">
            <div class="post-title">
                <?php if($model['pin_post']): ?>
                    <span class="pin-post fa fa-thumb-tack "></span>
                <?php endif ?>
                <?= Html::a($model['title'],[0 => 'post/view','id' => $model['id'],'title' => $model['title']]) ?>
            </div>
            <!-- -->
            <?php $postCategories = explode(',', $model['category_ids']) ?>
            <?php if($postCategories[0]): ?>
                <span class="post-detail">
					<span class="fa fa-list"></span>
                    <?php foreach ($postCategories as $category_id): ?>
                        <?= Html::a($this->params['categories'][$category_id],[0 => 'site/index','category' => $category_id,'title' => $this->params['categories'][$category_id]]) ?><delimiter>،</delimiter>
                    <?php endforeach; ?>
				</span>
            <?php endif ?>
            <span class="post-detail">
				<span class="fa fa-user"></span>
                <?= $model['last_name'] ?> <?= $model['surname'] ?>
			</span>
			<span class="post-detail">
				<span class="fa fa-calendar"></span>
                <?= Yii::$app->date->pdate($model['create_time']) ?>
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
                <?php if($model['more']): ?>
                    <hr class="more-hr">
                    <?= Html::a('بیشتر...',['post/view','id' => $model['id'] ,'title' => $model['title']],['class' => 'button more']) ?>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>

