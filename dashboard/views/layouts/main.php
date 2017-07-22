<?php
use dashboard\assets\AppAsset;
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
$entity_id = isset($_GET['id'])? (int)$_GET['id'] : null;
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
        <img class="user-profile" src="<?= Yii::$app->setting->getValue('url') ?>/dashboard/web/img/avatar.jpg">
    </div>

        <div class="header-split">
            <div class="dropdown">
                    <span class="fa fa-bars dropdown-toggle" data-toggle="dropdown"></span>
                <ul class="dropdown-menu pull-left raspina-menu">
                    <li><a href="<?= Url::base(); ?>/post/default">
                            <div><span class="fa fa-file-text"></span></div>
                            <div class="menu-title"><?= Yii::t('app', 'Posts') ?></div>
                        </a>
                    </li>
                    <li><a href="<?= Url::base(); ?>/post/category">
                            <div><span class="fa fa-book"></span></div>
                            <div class="menu-title"><?= Yii::t('app', 'Categories') ?></div>
                        </a>
                    </li>
                    <li><a href="<?= Url::base(); ?>/file">
                            <div><span class="fa fa-upload"></span></div>
                            <div class="menu-title"><?= Yii::t('app', 'Files') ?></div>
                        </a>
                    </li>
                    <li><a href="<?= Url::base(); ?>/newsletter">
                            <div><span class="fa fa-paper-plane"></span></div>
                            <div class="menu-title"><?= Yii::t('app', 'Newsletter') ?></div>
                        </a>
                    </li>
                    <li><a href="<?= Url::base(); ?>/link">
                            <div><span class="fa fa-link"></span></div>
                            <div class="menu-title"><?= Yii::t('app', 'Links') ?></div>
                        </a>
                    </li>
                    <li><a href="<?= Url::base(); ?>/statistics">
                            <div><span class="fa fa-line-chart"></span></div>
                            <div class="menu-title"><?= Yii::t('app', 'Statistics') ?></div>
                        </a>
                    </li>
                    <li><a href="#os">
                            <div><span class="fa fa-user"></span></div>
                            <div class="menu-title"><?= Yii::t('app', 'Users') ?></div>
                        </a>
                    </li>
                    <li><a href="#os">
                            <div><span class="fa fa-cog"></span></div>
                            <div class="menu-title"><?= Yii::t('app', 'Setting') ?></div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

    <div class="header-split" >
        <a href="<?= Url::base() . '/post/comment'; ?>">
            <span class="fa fa-comments" aria-hidden="true"></span>
            <?php
                $notApprovedCount = Comment::getNotApprovedCount();
                if($notApprovedCount):
            ?>
                <span class="alert-count"><?= $notApprovedCount ?></span>
            <?php endif; ?>

        </a>
    </div>

    <div class="header-split" >
        <a href="<?= Url::base() . '/contact'; ?>">
            <span class="fa fa-envelope" aria-hidden="true"></span>
            <?php
                $notViewedCount = Contact::getNotViewedCount();
                if($notViewedCount):
            ?>
                <span class="alert-count"><?= $notViewedCount ?></span>
            <?php endif; ?>
        </a>
    </div>
</div>

<?php if(($controller_id == 'site' || $modules_id == 'post') && $action_id == 'index'): ?>
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