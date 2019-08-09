<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\grid\GridView;
$this->title = Yii::t('app','Dashboard');

$this->registerCssFile(Yii::$app->homeUrl . 'app/web/css/jquery.mCustomScrollbar.css');

$this->registerJsFile(
    '@web/app/web/js/chart.bundle.min.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

$this->registerJsFile(
    '@web/app/web/js/jquery.mCustomScrollbar.concat.min.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

$this->registerJsFile(Yii::$app->homeUrl . 'app/web/js/chart_config.js');
?>

<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
    <div class="panel panel-default">
        <div class="panel-heading panel-status"><?= Yii::t('app','Visits today') ?></div>
        <div class="panel-body">
            <!-- -->
            <div class="panel-body-status"><?= $chart['today_visit'] ?></div>
            <!-- -->
        </div>
    </div>
</div>

<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
    <div class="panel panel-default">
        <div class="panel-heading panel-status"><?= Yii::t('app','Visitors today') ?></div>
        <div class="panel-body">
            <!-- -->
            <div class="panel-body-status"><?= $chart['today_visitors'] ?></div>
            <!-- -->
        </div>
    </div>
</div>

<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
    <div class="panel panel-default">
        <div class="panel-heading panel-status"><?= Yii::t('app','Visits yesterday') ?></div>
        <div class="panel-body">
            <!-- -->
            <div class="panel-body-status"><?= $chart['yesterday_visit'] ?></div>
            <!-- -->
        </div>
    </div>
</div>

<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
    <div class="panel panel-default">
        <div class="panel-heading panel-status"><?= Yii::t('app','Visitors yesterday') ?></div>
        <div class="panel-body">
            <!-- -->
            <div class="panel-body-status"><?= $chart['yesterday_visitors'] ?></div>
            <!-- -->
        </div>
    </div>
</div>
<div class="clear"></div>

<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading"><?= Yii::t('app','Last hits') ?></div>
        <div class="panel-body">
            <!-- -->
            <div class="last-visitors-lock">
                <span class="fa fa-lock icon"></span>
                <br>
                <span class="message"><?= Yii::t('app', 'Click To Unlock'); ?></span>
            </div>
            <div id="content-2" class="last-visitors">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?= Yii::t('app', 'IP') ?></th>
                            <th><?= Yii::t('app','Date') ?></th>
                            <th class="last-visitors-default-col fit"><?= Yii::t('app','OS') ?></th>
                            <th class="last-visitors-default-col"><?= Yii::t('app','Browser') ?></th>
                            <th class="last-visitors-default-col"><?= Yii::t('app','Location') ?></th>
                            <th class="last-visitors-default-col fit"><?= Yii::t('app','Referer') ?></th>
                            <th class="last-visitors-detail"><?= Yii::t('app','Detail') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $url = Yii::$app->setting->getValue('url');
                    $i = 1;
                    ?>
                    <?php foreach ((array)$visitors as $v): ?>
                        <tr>
                            <td class="fit"><?= $i++; ?></td>
                            <td class="fit"><?= $v['ip']; ?></td>
                            <td class="fit ltr"><?= Yii::$app->date->asDateTime($v['visit_date']); ?></td>
                            <td class="last-visitors-default-col fit"><?= $v['os']; ?></td>
                            <?php
                            $locationTitle = $visitorsModel->getTitle($url, $v['location']);
                            $refererTitle = $visitorsModel->getTitle($url, $v['referer']);
                            ?>
                            <td class="last-visitors-default-col fit"><?= $v['browser'] ?></td>
                            <td class="last-visitors-default-col"><a href="<?= $v['location']; ?>" target="_blank" style="text-align: left; direction: rtl"><?= $locationTitle ?></a></td>
                            <td style="direction: ltr" class="last-visitors-default-col fit">
                                <?php if($v['referer'] != null): ?>
                                    <a href="<?= $v['referer'] ?>" target="_blank"><?= $refererTitle ?></a>
                                <?php endif ?>
                            </td>
                            <td class="last-visitors-detail">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-default dropdown-toggle" type="button" data-toggle="dropdown" style="padding: 3px 7px 3px 7px; line-height: 0px;">
                                        <span class="fa fa-bars"></span></button>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="#os"><span class="fa fa-desktop"></span> <?= $v['os'] ?></a></li>
                                        <li><a href="#browser"><span class="fa fa-tablet"></span> <?= $v['browser'] ?></a></li>
                                        <li><a href="<?= $v['location'] ?>" target="_blank"><span class="fa fa-map-marker"></span> <?= $locationTitle ?></a></li>
                                        <?php if($v['referer'] != null): ?>
                                            <li><a href="<?= $v['referer'] ?>" target="_blank" style="direction: ltr"><?= $refererTitle ?> <span class="fa fa-link"></span></a></li>
                                        <?php endif ?>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- -->
        </div>
    </div>
</div>
<div class="col-md-12" style="margin-bottom: 25px;">
    <div class="panel panel-default">
        <div class="panel-heading"><?= Yii::t('app','Hits in last 30 days') ?></div>
        <div class="panel-body">
            <!-- -->
            <div style="width:100%; margin-top: -15px;">
                <canvas id="chart_visitors"></canvas>
                <script>
                    var chart_labels = <?= $chart['labels']; ?>;
                    var chart_max_visit = <?= $chart['max_visit']; ?>;
                    var visit_labels = '<?= $chart['visit']['title']; ?>';
                    var visit_data = <?= $chart['visit']['data']; ?>;
                    var visitor_labels = '<?= $chart['visitor']['title']; ?>';
                    var visitor_data = <?= $chart['visitor']['data']; ?>;
                </script>
            </div>
            <!-- -->
        </div>
    </div>
</div>
