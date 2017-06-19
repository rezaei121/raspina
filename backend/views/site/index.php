<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\grid\GridView;
use common\helpers\Raspina;
$this->title = Yii::t('app','Statistics and information');

$this->registerCssFile(Yii::$app->homeUrl . 'css/jquery.mCustomScrollbar.css');

$this->registerJsFile(
    '@web/js/chart.bundle.min.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

$this->registerJsFile(
    '@web/js/jquery.mCustomScrollbar.concat.min.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

$this->registerJsFile(Yii::$app->homeUrl . 'js/chart_config.js');
?>

<div class="col-md-3">
    <div class="panel panel-default">
        <div class="panel-heading panel-status"><?= Yii::t('app','today visits') ?></div>
        <div class="panel-body">
            <!-- -->
            <div class="panel-body-status"><?= $chart['today_visit'] ?></div>
            <!-- -->
        </div>
    </div>
</div>

<div class="col-md-3">
    <div class="panel panel-default">
        <div class="panel-heading panel-status"><?= Yii::t('app','today visitors') ?></div>
        <div class="panel-body">
            <!-- -->
            <div class="panel-body-status"><?= $chart['today_visitors'] ?></div>
            <!-- -->
        </div>
    </div>
</div>

<div class="col-md-3">
    <div class="panel panel-default">
        <div class="panel-heading panel-status"><?= Yii::t('app','yesterday visits') ?></div>
        <div class="panel-body">
            <!-- -->
            <div class="panel-body-status"><?= $chart['yesterday_visit'] ?></div>
            <!-- -->
        </div>
    </div>
</div>

<div class="col-md-3">
    <div class="panel panel-default">
        <div class="panel-heading panel-status"><?= Yii::t('app','yesterday visitors') ?></div>
        <div class="panel-body">
            <!-- -->
            <div class="panel-body-status"><?= $chart['yesterday_visitors'] ?></div>
            <!-- -->
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading"><?= Yii::t('app','last visited') ?></div>
        <div class="panel-body">
            <!-- -->
            <div class="last-visitors-lock">
                <span class="fa fa-lock icon"></span>
                <br>
                <span class="message"><?= Yii::t('app', 'click to unlock'); ?></span>
            </div>
            <div id="content-1" class="last-visitors">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?= Yii::t('app', 'ip') ?></th>
                            <th><?= Yii::t('app','date') ?></th>
                            <th class="last-visitors-default-col"><?= Yii::t('app','os') ?></th>
                            <th class="last-visitors-default-col"><?= Yii::t('app','browser') ?></th>
                            <th class="last-visitors-default-col"><?= Yii::t('app','location') ?></th>
                            <th class="last-visitors-default-col"><?= Yii::t('app','referer') ?></th>
                            <th class="last-visitors-detail"><?= Yii::t('app','detail') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $url = Yii::$app->setting->getValue('url');
                        $i = 1
                    ?>
                    <?php foreach ((array)$visitors as $v): ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $v['ip']; ?></td>
                            <td><?= Yii::$app->date->pdate($v['visit_date']); ?></td>
                            <td class="last-visitors-default-col"><?= $v['os']; ?></td>
                            <?php
                            $browser = explode(' ', $v['browser']);
                            $browserVesion = (isset($browser[1]) && (int)$browser[1] > 0) ? (int)$browser[1] : null;
                            ?>
                            <td class="last-visitors-default-col"><?= $browser[0] . ' ' . $browserVesion; ?></td>
                            <?php
                                $locationTitle = str_replace($url, null, $v['location']);
                                $locationTitle = preg_replace(['/^post\/view\/\d+\//', '/.html$/', '/site\/index.*%5B/', '/about\/index$/', '/contact\/index$/', '/^\/|\/$/'], null, $locationTitle);
                                if($locationTitle == '')
                                {
                                    $locationTitle = 'site/index';
                                }
                                $locationTitle = urldecode($locationTitle);
                                $locationTitle = (mb_strlen($locationTitle) > 20) ? mb_substr($locationTitle, 0, 19, 'utf-8') . '...' : $locationTitle;

                                $refererTitle = (mb_strlen($v['referer']) > 20) ? mb_substr($v['referer'], 0, 19, 'utf-8') . '...' : $v['referer'];
                            ?>
                            <td class="last-visitors-default-col"><a href="<?= $v['location']; ?>" target="_blank" style="text-align: left; direction: rtl"><?= urldecode($locationTitle) ?></a></td>
                            <td style="direction: ltr" class="last-visitors-default-col">
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
                                        <li><a href="#browser"><span class="fa fa-tablet"></span> <?= $browser[0] . ' ' . $browserVesion; ?></a></li>
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
        <div class="panel-heading"><?= Yii::t('app','the views graph') ?></div>
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