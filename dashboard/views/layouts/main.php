<?php

use dashboard\assets\AppAsset;
use dashboard\modules\user\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use dashboard\modules\post\models\Comment;
use dashboard\modules\contact\models\Contact;

AppAsset::register($this);

$modules_id = Yii::$app->controller->module->id;
$controller_id = Yii::$app->controller->id;
$action_id = Yii::$app->controller->action->id;
$entity_id = isset($_GET['id']) ? (int)$_GET['id'] : null;

?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta name="robots" content="noindex">
        <meta name="googlebot" content="noindex">
        <?= Html::csrfMetaTags() ?>
        <title><?= Yii::t('app', 'Raspina') ?> - <?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <script type="text/javascript">
            var base_url = '<?= Url::base() ?>';
            var modules_name = '<?= $modules_id ?>';
            var controller_name = '<?= $controller_id ?>';
            var action_name = '<?= $action_id ?>';
            var entity_id = '<?= $entity_id ?>';
        </script>
    </head>
    <body>
    <?php $this->beginBody() ?>
    <div class="header">
        <div class="header-split" style="margin-top: 8px;">
            <div class="dropdown">
                <img class="user-profile dropdown-toggle" data-toggle="dropdown" src="<?= User::getAvatar(Yii::$app->user->id); ?>">
                <ul class="dropdown-menu dropdown-menu-right raspina-profile ">
                    <div class="user-profile-h" style="">
                        <a href="<?= Url::base(); ?>/user/default/avatar"><img class="user-profile-big" src="<?= User::getAvatar(Yii::$app->user->id); ?>"></a>
                        <div class="user-profile-name"><?= Yii::$app->user->identity->last_name ?> <?= Yii::$app->user->identity->surname ?></div>
                        <div class="user-profile-name"><?= Yii::$app->user->identity->email ?></div>
                        <div><?= Html::a(Yii::t('app', 'My profile'), ['/user/default/profile'], ['class' => 'btn-sm btn-info user-profile-a']) ?></div>
                        <div style="margin-bottom: 8px;"><?= Html::a(Yii::t('app', 'Logout'), ['/user/default/logout'], ['class' => 'btn-sm btn-warning user-profile-a']) ?></div>
                    </div>
                </ul>
            </div>
        </div>

        <div class="header-split">
            <div class="dropdown">
                <span class="fa fa-bars dropdown-toggle" data-toggle="dropdown"></span>
                <ul class="dropdown-menu dropdown-menu-right raspina-menu">

                    <?php if (Yii::$app->user->can('post')): ?>
                        <li><a href="<?= Url::base(); ?>/post/default">
                                <div><span class="fa fa-file-text"></span></div>
                                <div class="menu-title"><?= Yii::t('app', 'Posts') ?></div>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (Yii::$app->user->can('category')): ?>
                        <li><a href="<?= Url::base(); ?>/post/category">
                                <div><span class="fa fa-book"></span></div>
                                <div class="menu-title"><?= Yii::t('app', 'Categories') ?></div>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (Yii::$app->user->can('file')): ?>
                        <li><a href="<?= Url::base(); ?>/file">
                                <div><span class="fa fa-upload"></span></div>
                                <div class="menu-title"><?= Yii::t('app', 'Files') ?></div>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (Yii::$app->user->can('newsletter')): ?>
                        <li><a href="<?= Url::base(); ?>/newsletter">
                                <div><span class="fa fa-paper-plane"></span></div>
                                <div class="menu-title"><?= Yii::t('app', 'Newsletter') ?></div>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (Yii::$app->user->can('link')): ?>
                        <li><a href="<?= Url::base(); ?>/link">
                                <div><span class="fa fa-link"></span></div>
                                <div class="menu-title"><?= Yii::t('app', 'Links') ?></div>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (Yii::$app->user->can('statistics')): ?>
                        <li><a href="<?= Url::base(); ?>/statistics">
                                <div><span class="fa fa-line-chart"></span></div>
                                <div class="menu-title"><?= Yii::t('app', 'Statistics') ?></div>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (Yii::$app->user->can('user')): ?>
                        <li><a href="<?= Url::base(); ?>/user">
                                <div><span class="fa fa-user"></span></div>
                                <div class="menu-title"><?= Yii::t('app', 'Users') ?></div>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (Yii::$app->user->can('Template')): ?>
                        <li><a href="<?= Url::base(); ?>/template">
                                <div><span class="fa fa-file-code-o"></span></div>
                                <div class="menu-title"><?= Yii::t('app', 'Template') ?></div>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (Yii::$app->user->can('settings')): ?>
                        <li><a href="<?= Url::base(); ?>/setting/default/update">
                                <div><span class="fa fa-cog"></span></div>
                                <div class="menu-title"><?= Yii::t('app', 'Settings') ?></div>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <?php if (Yii::$app->user->can('comment')): ?>
            <div class="header-split">
                <a href="<?= Url::base() . '/post/comment'; ?>">
                    <span class="fa fa-comments" aria-hidden="true"></span>
                    <?php
                    $notApprovedCount = Comment::getNotApprovedCount();
                    if ($notApprovedCount):
                        ?>
                        <span class="alert-count"><?= $notApprovedCount ?></span>
                    <?php endif; ?>

                </a>
            </div>
        <?php endif; ?>
        <?php if (Yii::$app->user->can('contact')): ?>
        <div class="header-split">
            <a href="<?= Url::base() . '/contact'; ?>">
                <span class="fa fa-envelope" aria-hidden="true"></span>
                <?php
                $notViewedCount = Contact::getNotViewedCount();
                if ($notViewedCount):
                    ?>
                    <span class="alert-count"><?= $notViewedCount ?></span>
                <?php endif; ?>
            </a>
        </div>
        <?php endif; ?>
    </div>


    <?php if (($controller_id == 'site' || $modules_id == 'post') && $action_id == 'index'): ?>
        <a href="<?= Url::base() . '/post/default/create'; ?>">
            <div class="pen">
                <img class="pen-icon" src="<?= Yii::$app->setting->getValue('url') ?>/dashboard/web/img/pen.svg">
            </div>
        </a>
    <?php endif; ?>

    <div class="pull-left main-content">
        <div class="col-md-12">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
        </div>
        <?= $content ?>
    </div>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>