<?php
use app\assets\DashboardAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\components\widgets\Alert;

DashboardAsset::register($this);

$modules_id = Yii::$app->controller->module->id;
$controller_id = Yii::$app->controller->id;
$action_id = Yii::$app->controller->action->id;
$entity_id = isset($_GET['id']) ? (int)$_GET['id'] : null;

// et urls...
$baseUrl = Url::home() . 'dashboard';
$contacUrl = "{$baseUrl}/contact";
$commentUrl = "{$baseUrl}/post/comment";
$postUrl = "{$baseUrl}/post";
$newPostUrl = "{$baseUrl}/post/default/create";
$categoryUrl = "{$baseUrl}/post/category";
$fileUrl = "{$baseUrl}/file";
$newsletterUrl = "{$baseUrl}/newsletter";
$linkUrl = "{$baseUrl}/link";
$statisticsUrl = "{$baseUrl}/statistics";
$userUrl = "{$baseUrl}/user";
$templateUrl = "{$baseUrl}/template";
$settingUrl = "{$baseUrl}/setting/default/update";
$avatarUrl = "{$baseUrl}/user/default/avatar";

$notApprovedCommentCount = \app\modules\post\models\Comment::getNotApprovedCount();
$notViewedContactCount = \app\modules\contact\models\Contact::getNotViewedCount();
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
    <div class="base-container">
        <div class="menu-container col-lg-2 col-md-2 col-sm-2">
                <!-- menu start -->
                <div class="top-menu v-center">
                    <div>
                        <div class="raspina-logo"></div>
                        <div class="raspina-name">Raspina</div>
                    </div>
                </div>
                        <a href="<?= $avatarUrl ?>">
                            <div class="rs-profile-content">
                                <div class="rs-profile-image"><img src="<?= \app\modules\user\models\User::getAvatar(Yii::$app->user->id); ?>"></div>
                                <div class="rs-profile-text">
                                    <span style="font-weight: bold"><?= Yii::$app->user->identity->last_name ?> <?= Yii::$app->user->identity->surname ?></span><br>
                                    <span>مدیر وبلاگ</span>
                                </div>
                            </div>
                        </a>
                        <div class="clear"></div>
                <ul class="menu-item" style="width: 100%">
                    <?php if (Yii::$app->user->can('post')): ?>
                        <li class="menu-item-child">
                            <a href="<?= $postUrl; ?>"><span class="fa fa-file-text"></span> <div><?= Yii::t('app', 'Posts') ?></div></a>
                        </li>
                    <?php endif; ?>

                    <?php if (Yii::$app->user->can('category')): ?>
                        <li class="menu-item-child">
                            <a href="<?= $categoryUrl; ?>"><span class="fa fa-book"></span> <div><?= Yii::t('app', 'Categories') ?></div></a>
                        </li>
                    <?php endif; ?>

                    <?php if (Yii::$app->user->can('file')): ?>
                        <li class="menu-item-child">
                            <a href="<?= $fileUrl; ?>"><span class="fa fa-upload"></span> <div><?= Yii::t('app', 'Files') ?></div></a>
                        </li>
                    <?php endif; ?>

                    <?php if (Yii::$app->user->can('newsletter')): ?>
                        <li class="menu-item-child">
                            <a href="<?= $newsletterUrl; ?>"><span class="fa fa-paper-plane"></span> <div><?= Yii::t('app', 'Newsletter') ?></div></a>
                        </li>
                    <?php endif; ?>

                    <?php if (Yii::$app->user->can('link')): ?>
                        <li class="menu-item-child">
                            <a href="<?= $linkUrl; ?>"><span class="fa fa-link"></span> <div><?= Yii::t('app', 'Links') ?></div></a>
                        </li>
                    <?php endif; ?>

                    <?php if (Yii::$app->user->can('statistics')): ?>
                        <li class="menu-item-child">
                            <a href="<?= Url::base(); ?>/statistics"><span class="fa fa-line-chart"></span> <div><?= Yii::t('app', 'Statistics') ?></div></a>
                        </li>
                    <?php endif; ?>

                    <?php if (Yii::$app->user->can('user')): ?>
                        <li class="menu-item-child">
                            <a href="<?= $userUrl; ?>"><span class="fa fa-user"></span> <div><?= Yii::t('app', 'Users') ?></div></a>
                        </li>
                    <?php endif; ?>

                    <?php if (Yii::$app->user->can('template')): ?>
                        <li class="menu-item-child">
                            <a href="<?= $templateUrl; ?>"><span class="fa fa-file-code-o"></span> <div><?= Yii::t('app', 'Template') ?></div></a>
                        </li>
                    <?php endif; ?>

                    <?php if (Yii::$app->user->can('settings')): ?>
                        <li class="menu-item-child">
                            <a href="<?= $settingUrl; ?>"><span class="fa fa-cog"></span> <div><?= Yii::t('app', 'Settings') ?></div></a>
                        </li>
                    <?php endif; ?>
                </ul>
                <!-- menu end -->
            <br>
        </div>
        <div class="main-container col-lg-10 col-md-10 col-sm-10">
            <div class="top-main-container">
                <a href="<?= $newPostUrl ?>">
                    <div class="new-post">
                        <div class="pen">
                            <div><?= Yii::t('app', 'New Post') ?></div>
                        </div>
                    </div>
                </a>
                <?php if (Yii::$app->user->can('contact')): ?>
                    <div class="header-split" style="padding-top: 10px;">
                        <a href="<?= $contacUrl; ?>">
                            <span class="fa fa-envelope" aria-hidden="true" style="font-size: 25px;"></span>
                            <?php
                            if ($notViewedContactCount):
                                ?>
                                <span class="alert-count"><?= $notViewedContactCount ?></span>
                            <?php endif; ?>
                        </a>
                    </div>
                <?php endif; ?>
                <?php if (Yii::$app->user->can('comment')): ?>
                    <div class="header-split">
                        <a href="<?= $commentUrl; ?>">
                            <span class="fa fa-comments" aria-hidden="true"></span>
                            <?php
                            if ($notApprovedCommentCount):
                                ?>
                                <span class="alert-count"><?= $notApprovedCommentCount ?></span>
                            <?php endif; ?>
                        </a>
                    </div>
                <?php endif; ?>

            </div>
            <div class="col-md-12">
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
                <?= Alert::widget() ?>
            </div>
            <?= $content ?>
        </div>
    </div>

    <!-- sm menu -->
    <div class="sm-menu">
        <div class="menu-section-1">
            <a href="<?= $contacUrl; ?>">
                <span class="fa fa-envelope">
                    <?php if ($notViewedContactCount): ?>
                    <div class="alert-count"><?= $notViewedContactCount ?></div>
                    <?php endif; ?>
                </span>
            </a>
            <a href="<?= $commentUrl; ?>">
                <span class="fa fa-comments">
                    <?php if ($notApprovedCommentCount): ?>
                        <div class="alert-count"><?= $notApprovedCommentCount ?></div>
                    <?php endif; ?>
                </span>
            </a>
            <a href="<?= $newPostUrl; ?>">
                <span class="fa fa-plus-square"></span>
            </a>
            <a href="<?= $postUrl; ?>">
                <span class="fa fa-file-text"></span>
            </a>
            <a href="#" id="more-menu">
                <span class="fa fa-bars dropdown-toggle"></span>
            </a>
        </div>
        <div class="menu-section-2">
            <a href="#">
                <span class="fa fa-chevron-down down-menu"></span>
            </a>
            <div class="clear"></div>
            <a href="<?= $contacUrl; ?>">
                <span class="fa fa-envelope">
                    <?php if ($notViewedContactCount): ?>
                        <div class="alert-count"><?= $notViewedContactCount ?></div>
                    <?php endif; ?>
                </span>
                <div class="menu-section-2-menu-title"><?= Yii::t('app', 'Contacts') ?></div>
            </a>
            <a href="<?= $commentUrl; ?>">
                <span class="fa fa-comments">
                    <?php if ($notApprovedCommentCount): ?>
                        <div class="alert-count"><?= $notApprovedCommentCount ?></div>
                    <?php endif; ?>
                </span>
                <div class="menu-section-2-menu-title"><?= Yii::t('app', 'Comments') ?></div>
            </a>
            <a href="<?= $newPostUrl; ?>">
                <span class="fa fa-plus-square"></span>
                <div class="menu-section-2-menu-title"><?= Yii::t('app', 'New Post') ?></div>
            </a>
            <div class="clear"></div>
            <a href="<?= $fileUrl; ?>">
                <span class="fa fa-upload"></span>
                <div class="menu-section-2-menu-title"><?= Yii::t('app', 'Files') ?></div>
            </a>
            <a href="<?= $categoryUrl; ?>">
                <span class="fa fa-book"></span>
                <div class="menu-section-2-menu-title"><?= Yii::t('app', 'Categories') ?></div>
            </a>
            <a href="<?= $postUrl; ?>">
                <span class="fa fa-file-text"></span>
                <div class="menu-section-2-menu-title"><?= Yii::t('app', 'Posts') ?></div>
            </a>
            <div class="clear"></div>
            <a href="<?= $newsletterUrl; ?>">
                <span class="fa fa-paper-plane"></span>
                <div class="menu-section-2-menu-title"><?= Yii::t('app', 'Newsletter') ?></div>
            </a>
            <a href="#">
                <span class="fa fa-link"></span>
                <div class="menu-section-2-menu-title"><?= Yii::t('app', 'Links') ?></div>
            </a>
            <a href="<?= $statisticsUrl; ?>">
                <span class="fa fa-line-chart"></span>
                <div class="menu-section-2-menu-title"><?= Yii::t('app', 'Statistics') ?></div>
            </a>
            <div class="clear"></div>
            <a href="<?= $userUrl; ?>">
                <span class="fa fa-user"></span>
                <div class="menu-section-2-menu-title"><?= Yii::t('app', 'Users') ?></div>
            </a>
            <a href="<?= $templateUrl; ?>">
                <span class="fa fa-file-code-o"></span>
                <div class="menu-section-2-menu-title"><?= Yii::t('app', 'Template') ?></div>
            </a>
            <a href="<?= $settingUrl; ?>">
                <span class="fa fa-cog"></span>
                <div class="menu-section-2-menu-title"><?= Yii::t('app', 'Settings') ?></div>
            </a>
        </div>
    </div>
    <!-- /sm menu -->

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>