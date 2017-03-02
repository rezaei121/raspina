<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);

$modules_id = Yii::$app->controller->module->id;
$controller_id = Yii::$app->controller->id;
$action_id = Yii::$app->controller->action->id;
$entity_id = isset($_GET['id'])? (int)$_GET['id'] : 0;
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
    <title>رسپینا - <?= Html::encode($this->title) ?></title>
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
<div class="top-head">
    <a href="<?= Url::base() ?>">
        <div class="raspina pull-right">
            <div class="rs-name"><?= Yii::t('app','Raspina') ?></div>
            <div class="rs-version"><?= Yii::t('app','Version') ?></div>
        </div>
    </a>
    <ul class="top-item pull-right">
        <a href="<?= Url::base() . '/post/default/create'; ?>">
            <li>
                <div class="fa fa-plus"></div>
            </li>
        </a>
        <a href="<?= Url::base() . '/post/comment'; ?>">
            <li class="<?= $active = ($modules_id == 'comment') ? 'rs-active' : '' ?>">
                <div class="fa fa-comments"></div>
                <?php
                    $countNotAccepted = \backend\modules\post\models\Comment::getCountNotAccepted();
                    if($countNotAccepted):
                ?>
                    <div class="item-notification"><?= $countNotAccepted ?></div>
                <?php endif; ?>
            </li>
        </a>
        <a href="<?= Url::base() . '/contact'; ?>">
            <li class="<?= $active = ($modules_id == 'contact') ? 'rs-active' : '' ?>">
                <div class="fa fa-envelope-o"></div>
                <?php
                    $CountNotVisited = \backend\modules\contact\models\Contact::getCountNotVisited();
                    if($CountNotVisited):
                ?>
                <div class="item-notification"><?= $CountNotVisited ?></div>
                <?php endif; ?>
            </li>
        </a>
        <?php
        $countMails = backend\modules\newsletter\models\Newsletter::getCountMails();
        ?>
        <a href="<?= Url::base() . '/newsletter'; ?>">
            <li class="<?= $active = ($modules_id == 'newsletter' && $action_id == 'index') ? 'rs-active' : '' ?>">
                <div class="fa fa-users"></div>
                <?php if($countMails): ?>
                <div class="item-notification"><?= $countMails ?></div>
            <?php endif; ?>
            </li>
        </a>
    </ul>

    <ul class="top-item pull-left">
        <a href="<?= Url::base() . '/user/logout'; ?>">
            <li>
                <div class="fa fa-sign-out"></div>
            </li>
        </a>
    </ul>
    <div class="clear"></div>
</div>
<div class="container" style="width: 100%; min-height: 100%;">
    <div class="row" style="border-right: 72px solid #383A3F;">
        <!-- tools start -->
        <div class="rs-tools">
            <a href="<?= Yii::$app->setting->getValue('url'); ?>" target="_blank">
                <div class="rs-item">
                    <div class="fa fa-television rs-icon"></div>
                    <div class="rs-tool-title"><?= Yii::t('app','View Site') ?></div>
                </div>
            </a>
            <div class="group-items <?= $active = ($modules_id == 'post' || $modules_id == 'category') ? 'rs-open' : '' ?>">
                <div class="rs-item  <?= $active = ($modules_id == 'post' || $modules_id == 'category') ? 'rs-active' : '' ?>">
                    <div class="fa fa-file-text-o rs-icon"></div>
                    <div class="rs-tool-title"><?= Yii::t('app', 'Posts') ?></div>
                </div>
                <div class="sub-item">
                    <a href="<?= Url::base() . '/post/default/create'; ?>">
                        <div class="rs-item">
                            <div class="fa fa fa-plus rs-icon"></div>
                            <div class="rs-tool-title"><?= Yii::t('app','Create Post') ?></div>
                        </div>
                    </a>
                    <a href="<?= Url::base() . '/post'; ?>">
                        <div class="rs-item">
                            <div class="fa fa fa-list rs-icon"></div>
                            <div class="rs-tool-title"><?= Yii::t('app','Posts') ?></div>
                        </div>
                    </a>
                    <a href="<?= Url::base() . '/post?PostSearch%5Bstatus%5D=0'; ?>">
                        <div class="rs-item">
                            <div class="fa fa fa-clone rs-icon"></div>
                            <div class="rs-tool-title"><?= Yii::t('app','Drafts') ?></div>
                        </div>
                    </a>

                    <a href="<?= Url::base() . '/post/category'; ?>">
                        <div class="rs-item">
                            <div class="fa fa fa-book rs-icon"></div>
                            <div class="rs-tool-title"><?= Yii::t('app','Categories') ?></div>
                        </div>
                    </a>
                </div>
            </div>

            <a href="<?= Url::base() . '/newsletter/default/create'; ?>">
                <div class="rs-item <?= $active = ($modules_id == 'newsletter' && $action_id == 'create') ? 'rs-active' : '' ?>">
                    <div class="fa fa-envelope-o rs-icon"></div>
                    <div class="rs-tool-title"><?= Yii::t('app','Send Newsletter') ?></div>
                </div>
            </a>

            <a href="<?= Url::base() . '/link'; ?>">
                <div class="rs-item <?= $active = ($modules_id == 'link') ? 'rs-active rs-open' : '' ?>">
                    <div class="fa fa-link rs-icon"></div>
                    <div class="rs-tool-title"><?= Yii::t('app','Links') ?></div>
                </div>
            </a>
            <div class="group-items <?= $active = ($modules_id == 'file') ? 'rs-open' : '' ?>"">
                <div class="rs-item <?= $active = ($modules_id == 'file') ? 'rs-active' : '' ?>"">
                    <div class="fa fa-upload rs-icon"></div>
                    <div class="rs-tool-title"><?= Yii::t('app','Files Manager') ?></div>
                </div>
                <div class="sub-item">
                    <a href="<?= Url::base() . '/file/default/upload'; ?>">
                        <div class="rs-item">
                            <div class="fa fa fa-plus rs-icon"></div>
                            <div class="rs-tool-title"><?= Yii::t('app','Upload File') ?></div>
                        </div>
                    </a>
                    <a href="<?= Url::base() . '/file'; ?>">
                        <div class="rs-item">
                            <div class="fa fa fa-list rs-icon"></div>
                            <div class="rs-tool-title"><?= Yii::t('app','Files') ?></div>
                        </div>
                    </a>
                </div>
            </div>

            <a href="<?= Url::base() . '/about'; ?>">
            <div class="rs-item">
                <div class="fa fa-info-circle rs-icon"></div>
                <div class="rs-tool-title"><?= Yii::t('app','About') ?></div>
            </div>
            </a>
            <a href="<?= Url::base() . '/setting/update'; ?>">
                <div class="rs-item <?= $active = ($controller_id == 'setting') ? 'rs-active' : '' ?>">
                    <div class="fa fa-cog rs-icon"></div>
                    <div class="rs-tool-title"><?= Yii::t('app','Settings') ?></div>
                </div>
            </a>
        </div>
        <!-- tools end -->
        <!-- main start -->
        <div class="pull-left main-content">
            <div class="col-md-12">
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
                <?= Alert::widget() ?>
            </div>
            <?= $content ?>
        </div>
        <!-- main end -->

    </div>
</div>
<div class="footer">
    <div class="raspina" style="width: 72px; float: right">
        <div class="rs-name"><span class="fa fa-copyright" style="font-size: 18px;"></span></div>
        <div class="rs-version">2016</div>
    </div>
    <div class="rsabout">
        <a href="http://www.developit.ir/" target="_blank"><?= Yii::t('app','Powered By Raspina CMS') ?></a>
    </div>
</div>
<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>