<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use common\widgets\Alert;
//use frontend\assets\AppAsset;
//AppAsset::register($this);
$site = $this->params;
$this->beginPage();
?>
<html lang="<?= $site['lang'] ?>">
<head>
	<meta charset="<?= $site['charset'] ?>">
	<?= $site['csrfMetaTags'] ?>
	<title><?= $site['title'] ?></title>
	<meta name="description" content="<?= $site['description'] ?>">
	<meta name="keywords" content="<?= $site['keywords'] ?>">
	<meta name="author" content="">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=0.9, user-scalable=no" />
	<?php $this->head() ?>
	<link rel="stylesheet" href="<?= $site['templateUrl'] ?>css/bootstrap.min.css">
	<link rel="stylesheet" href="<?= $site['templateUrl'] ?>css/reset.css">
	<link type="text/css" rel="stylesheet" href="<?= $site['templateUrl'] ?>css/font-awesome.min.css">
	<link rel="stylesheet" href="<?= $site['templateUrl'] ?>css/style.css">
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
		<div class="col-sm-12">
				<span class="fa fa-globe top-icon"></span>
				<span class="h-title">
					<?= $site['subject'] ?><br>
					<span class="h-description"><?= $site['site_description'] ?></span>
				</span>

		</div>

	</div>

	<div class="h-menu-box">
			<ul class="h-menu">
				<li><a href="<?= $site['url'] ?>">خانه</a></li>
				<li><a href="<?= $site['url'] ?>about/index">درباره</a></li>
				<li><a href="<?= $site['url'] ?>contact/index">تماس با من</a></li>
				<li><a href="<?= $site['url'] ?>site/rss" target="_blank">RSS</a></li>
				<li><a href="<?= $site['url'] ?>backend/web/site/login">ورود</a></li>
			</ul>
			<div class="clear"></div>
	</div>

</div>
<!-- /header -->
<div class="container" id="wrap">
	<div class="row" style="margin-top: 60px;">
		<div class="col-sm-9" style=" line-height=> 0px;">
			<?= Alert::widget() ?>
			<?= $content ?>
		</div>
		<div class="col-sm-3">
			<!-- -->
			<?php if($site['about']['name']): ?>
	<div class="panel panel-default about-panel">
		<div class="panel-body">
			<?php if($site['about']['avatar']): ?>
		<img class="about-image" src="<?= $site['url'] ?>common/files/avatar/<?= $site['about']['avatar'] ?>">
			<?php endif ?>
		<div class="about-name"><?= $site['about']['name'] ?></div>
		<div class="about-text"><?= $site['about']['short_text'] ?></div>

			<div class="about-rs">
				<?php if($site['about']['facebook']): ?>
				<a href="<?= $site['about']['facebook'] ?>" target="_blank"><span class="fa fa-facebook"></span></a>
				<?php endif ?>

				<?php if($site['about']['twitter']): ?>
				<a href="<?= $site['about']['twitter'] ?>" target="_blank"><span class="fa fa-twitter"></span></a>
				<?php endif ?>

				<?php if($site['about']['googleplus']): ?>
				<a href="<?= $site['about']['googleplus'] ?>" target="_blank"><span class="fa fa-google-plus "></span></a>
				<?php endif ?>

				<?php if($site['about']['instagram']): ?>
				<a href="<?= $site['about']['instagram'] ?>" target="_blank"><span class="fa fa-instagram"></span></a>
				<?php endif ?>

				<?php if($site['about']['linkedin']): ?>
				<a href="<?= $site['about']['linkedin'] ?>" target="_blank"><span class="fa fa-linkedin "></span></a>
				<?php endif ?>

			</div>
		</div>
	</div>
			<?php endif ?>
			<div class="post-border shadow">
				<div class="panel panel-default post-panel menu-panel">
					<div class="panel-body">
						<div class="menu-title">
							<span class="fa fa-search menu-title-icon" aria-hidden="true"></span>
							<span class="menu-title-text">جستجو</span>
						</div>
						<div class="menu-title-line"></div>
						<?php $form = ActiveForm::begin(['action'=> ['site/index'],'method'=> 'GET']) ?>
							<?= $form->field($site['index'],'search')->textInput(['maxlength'=> true,'class'=> 'input margin-17','placeholder'=> 'متن جستجو...']) ?>
							<?= Html::submitButton('بگرد!',['class'=> 'submit']) ?>
						<?php ActiveForm::end() ?>
					</div>
				</div>
			</div>

			<div class="post-border shadow">
				<div class="panel panel-default post-panel menu-panel">
					<div class="panel-body">
						<div class="menu-title">
							<span class="fa fa-envelope-o menu-title-icon" aria-hidden="true"></span>
							<span class="menu-title-text">خبرنامه</span>
						</div>
						<div class="menu-title-line"></div>
						<?php $form = ActiveForm::begin(['action'=> ['newsletter/join']]) ?>
							<?= $form->field($site['newsletter'],'email')->textInput(['maxlength'=> true,'class'=> 'input margin-17','placeholder'=> 'Emale Adress...','dir'=> 'ltr']) ?>
							<?= Html::submitButton('عضویت',['class'=> 'submit']) ?>
						<?php ActiveForm::end() ?>
					</div>
				</div>
			</div>

	<?php if($site['categories']): ?>
	<div class="post-border shadow">
		<div class="panel panel-default post-panel menu-panel">
			<div class="panel-body">
				<div class="menu-title">
					<span class="fa fa-folder-open menu-title-icon"></span>
					<span class="menu-title-text">دسته بندی ها</span>
				</div>
				<div class="menu-title-line"></div>
				<?php foreach((array)$site['categories'] as $id => $category): ?>
					<div class="cat-item">
						<?= Html::a($category,[0=> 'site/index','category'=> $id,'title'=>$category]); ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
	<?php endif ?>

			<?php if($site['links']): ?>
				<div class="post-border shadow">
					<div class="panel panel-default post-panel menu-panel">
						<div class="panel-body">
							<div class="menu-title">
								<span class="fa fa-link menu-title-icon"></span>
								<span class="menu-title-text">پیوند ها</span>
							</div>
							<div class="menu-title-line"></div>
							<?php foreach ((array)$site['links'] as $link): ?>
								<div class="cat-item">
									<a href="<?= $link['url'] ?>" target="_blank"><?= $link['title'] ?></a>
								</div>
							<?php endforeach ?>
						</div>
					</div>
				</div>
			<?php endif ?>

			<!-- -->
		</div>
	</div>
</div>
<div class="footer" style="text-align: center">
	<span>کلیه حقوق این وب سایت متعلق به مالک آن می باشد و کپی برداری از محتوای سایت تنها با ذکر منبع مجاز است</span>
	<br>
	<span><a href="http://www.developit.ir" target="_blank">قدرت گرفته از رَسپینا</a></span>
</div>
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="<?= $site['templateUrl'] ?>js/jquery-2.2.3.min.js"></script>
	<script src="<?= $site['templateUrl'] ?>js/mycode.js"></script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>