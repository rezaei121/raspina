<?php
use app\components\helpers\Raspina;
use app\components\widgets\ActiveForm;
use app\modules\post\models\Category;
use app\themes\theme01\Asset;
use app\modules\post\models\Post;
use app\components\helpers\Html;
use app\modules\link\models\Link;
use app\components\widgets\Alert;

Asset::register($this);
$this->beginPage();
?>
<html lang="<?= Raspina::lang() ?>">
<head>
	<meta charset="<?= Raspina::charset() ?>">
	<?= Raspina::csrfMetaTags() ?>
	<title><?= Raspina::title() ?></title>
	<meta name="description" content="<?= Raspina::description() ?>">
	<meta name="keywords" content="<?= Raspina::keywords() ?>">
	<meta name="author" content="">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=0.9, user-scalable=no" />
	<?php $this->head() ?>
    <?php
    // add rtl style
    if(Raspina::direction() == 'rtl'):
    ?>
        <link rel="stylesheet" href="<?= Raspina::templateUrl() ?>/css/style-rtl.css">
    <?php endif; ?>

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING=> Respond.js doesn't work if you view the page via file=>// -->
	<!--[if lt IE 9]>
	<script src="https://www.oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://www.oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
<?php $this->beginBody() ?>
<!-- header -->
<div class="">
	<div class="header">
        <div class="h-title"><?= Raspina::subject() ?></div>
        <div class="h-description"><?= Raspina::siteDescription() ?></div>

        <div class="h-menu-box">
            <ul>
                <li><a href="<?= Raspina::url() ?>/home"><?= Raspina::t('Home') ?></a></li>
                <li><a href="<?= Raspina::url() ?>user/default/about"><?= Raspina::t('About') ?></a></li>
                <li><a href="<?= Raspina::url() ?>contact/default/index"><?= Raspina::t('Contact Me') ?></a></li>
                <li><a href="<?= Raspina::url() ?>post/default/rss" target="_blank"><?= Raspina::t('RSS') ?></a></li>
                <li><a href="<?= Raspina::url() ?>dashboard"><?= Raspina::t('Login') ?></a></li>
            </ul>
            <div class="clear"></div>
        </div>
	</div>
</div>
<!-- /header -->
<div class="container" id="wrap">
	<div class="row" style="margin-top: 35px;">
		<div class="col-sm-9" style=" line-height=> 0px;">
            <?= Alert::widget() ?>
			<?= $content ?>
		</div>
		<div class="col-sm-3">
			<!-- -->
			<div class="post-border shadow">
				<div class="panel panel-default post-panel menu-panel">
					<div class="panel-body">
						<div class="menu-title">
							<span class="fa fa-search menu-title-icon" aria-hidden="true"></span>
							<span class="menu-title-text"><?= Raspina::t('Search') ?></span>
						</div>
						<div class="menu-title-line"></div>
						<?php $form = ActiveForm::begin(['action'=> ['/home/default'],'method'=> 'GET']) ?>
							<?= $form->field(new Post,'search')->textInput(['maxlength'=> true,'class'=> 'input margin-17','placeholder'=> Raspina::t('Text')]) ?>
							<?= Html::submitButton(Raspina::t('Go'),['class'=> 'submit']) ?>
						<?php ActiveForm::end() ?>
					</div>
				</div>
			</div>

	<div class="post-border shadow">
		<div class="panel panel-default post-panel menu-panel">
			<div class="panel-body">
				<div class="menu-title">
					<span class="fa fa-folder-open menu-title-icon"></span>
					<span class="menu-title-text"><?= Raspina::t('Categories') ?></span>
				</div>
				<div class="menu-title-line"></div>
				<?php foreach(Category::getAll() as $id => $category): ?>
					<div class="cat-item">
						<?= Html::a($category,[0=> '/home/default/index','category'=> $id,'title'=>$category]); ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>

				<div class="post-border shadow">
					<div class="panel panel-default post-panel menu-panel">
						<div class="panel-body">
							<div class="menu-title">
								<span class="fa fa-link menu-title-icon"></span>
								<span class="menu-title-text"><?= Raspina::t('Links') ?></span>
							</div>
							<div class="menu-title-line"></div>
							<?php foreach ((Link::find()->all()) as $link): ?>
								<div class="cat-item">
									<a href="<?= $link['url'] ?>" target="_blank"><?= $link['title'] ?></a>
								</div>
							<?php endforeach ?>
						</div>
					</div>
				</div>

			<!-- -->
		</div>
	</div>
</div>
<div class="footer" style="text-align: center">
	<span><?= Raspina::t('All rights reserved by the owner of this site and the copying of the site content is permitted only by mentioning the source and the link.') ?></span>
	<br>
	<span><a href="http://www.developit.ir/github/raspina.html" target="_blank"><?= Raspina::t('Powered by raspina cms') ?></a></span>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>