<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\grid\GridView;
use common\helpers\Raspina;
$this->title = Yii::t('app','Statistics and information');

$this->registerJsFile(Yii::$app->homeUrl . 'js/chart.bundle.min.js');
$this->registerJsFile(Yii::$app->homeUrl . 'js/chart_config.js');
?>
<style>
    canvas{
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
    }
    .grid-view {width: 100%;}
</style>
<!--<div class="col-md-3">-->
<!--    <div class="panel panel-default" style="border-top: 3px solid #F6B352">-->
<!--        <div class="panel-body" style="padding-top: 0px; padding-left: 0px; padding-right: 0px; padding-bottom: 0px;">-->
<!--            <div class="user-box-bg">-->
<!--                <img src="--><?//= Yii::$app->setting->getValue('url') ?><!--/backend/web/img/user-box-bg.jpg" width="100%">-->
<!--            </div>-->
<!--            <div class="clear"></div>-->
<!--            <img class="user-avatar" src="--><?//= $user->avatar ?><!--">-->
<!--            <div class="user-detail">-->
<!--                <div>--><?//= $user->last_name ?><!-- --><?//= $user->surname ?><!-- --><?//= Yii::t('app', 'Welcome')  ?><!--</div>-->
<!--                <div>--><?//= $user->email ?><!--</div>-->
<!--            </div>-->
<!--            <div class="clear"></div>-->
<!--            <hr style="margin: 10px 0px 0px 0px;">-->
<!--            <div class="col-md-6" style="padding: 10px 10px 0px 10px; margin-bottom: 0px;">-->
<!--                <a href="--><?//= Url::base() . '/user/changepassword'; ?><!--" class="btn btn-default" role="button" style="float: left; font-size: 11px; width: 100%; margin-bottom: 10px;">--><?//= Yii::t('app','Edit Password') ?><!--</a>-->
<!--            </div>-->
<!--            <div class="col-md-6" style="padding: 10px 10px 0px 10px; margin-bottom: 0px;">-->
<!--                <a href="--><?//= Url::base() . '/user/account'; ?><!--" class="btn btn-default" role="button" style="float: right; font-size: 11px; width: 100%;margin-bottom: 10px;">--><?//= Yii::t('app','User Profile') ?><!--</a>-->
<!--            </div>-->
<!--            <div class="clear"></div>-->
<!--        </div>-->
<!--    </div>-->

<!--    <div class="panel panel-default">-->
<!--        <div class="panel-heading">--><?//= Yii::t('app','Viewers Statistics') ?><!--</div>-->
<!--        <div class="panel-body">-->
<!--            <div>--><?//= Yii::t('app','Today') ?><!--: <span>--><?//= Yii::$app->date->pdate(time(),'Y/MM/dd') ?><!--</span></div>-->
<!--            <div>--><?//= Yii::t('app','Today Visit') ?><!--: <span>--><?//= $chart['today_visit'] ?><!--</span></div>-->
<!--            <div>--><?//= Yii::t('app','Today Visitors') ?><!--: <span>--><?//= $chart['today_visitors'] ?><!--</span></div>-->
<!--            <div>--><?//= Yii::t('app','Yesterday Visit') ?><!--: <span>--><?//= $chart['yesterday_visit'] ?><!--</span></div>-->
<!--            <div>--><?//= Yii::t('app','Yesterday Visitors') ?><!--: <span>--><?//= $chart['yesterday_visitors'] ?><!--</span></div>-->
<!--        </div>-->
<!--    </div>-->
<!---->
<!--</div>-->

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
            <div class="last-visitors">
                <table class="table table-striped table-bordered">
                    <tbody>
                    <?php foreach ((array)$visitors as $v): ?>
                        <tr>
                            <td>
                                <div>
                                                <span class="last-visitors-item">
                                                    <span class="fa fa-user"></span> <?= $v['ip']; ?>
                                                </span>
                                                <span class="last-visitors-item">
                                                    <span class="fa fa-clock-o"></span> <?= Yii::$app->date->pdate($v['visit_date']); ?>
                                                </span>
                                                <span class="last-visitors-item">
                                                    <span class="fa fa-desktop"></span> <?= $v['os']; ?>
                                                </span>
                                                <span class="last-visitors-item">
                                                    <span class="fa fa-tablet"></span> <?= $v['browser']; ?>
                                                </span>
                                </div>
                                <div class="clear"></div>
                                <span><?= Yii::t('app','Location') ?></span>: <a href="<?= $v['location']; ?>" target="_blank" style="text-align: left; direction: rtl"><?= urldecode(rtrim($v['location'],'/')); ?></a><br>
                                <span><?= Yii::t('app','Referer') ?></span>: <a href="<?= $v['referer']; ?>" target="_blank"><?= urldecode(rtrim($v['referer'],'/')); ?></a>
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
<div class="col-md-12">
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

<div class="col-md-6">
    <div class="panel panel-default">
        <div class="panel-heading"><?= Yii::t('app','Search Engine') ?></div>
        <div class="panel-body">
            <!-- -->
            <div style="padding: 10px; min-height: 290px; ">
                <div style="height: auto; margin-bottom: 0px;width:100%;max-width: 500px; text-align: center; margin: 0 auto">
                    <canvas id="chart_pie"/>
                    <script>
                        var pie_chart_data = <?= $pie_chart; ?>;
                    </script>
                </div>
            </div>
            <!-- -->
        </div>
    </div>
</div>

<div class="col-md-6">
    <div class="panel panel-default">
        <div class="panel-heading"><?= Yii::t('app','Visit Period') ?></div>
        <div class="panel-body">
            <!-- -->
            <span style="padding: 10px;">
                <div id="container" style="max-width: 500px; text-align: center; margin: 0 auto">
                    <canvas id="line" dir="rtl"></canvas>
                    <script>
                        var visit_period_data = <?= $visit_period; ?>;
                    </script>
                </div>
            </span>
            <!-- -->
        </div>
    </div>
</div>

<!--<div class="col-md-12">-->
<!--    <div class="panel panel-default">-->
<!--        <div class="panel-heading">--><?//= Yii::t('app','Most Viewed Posts') ?><!--</div>-->
<!--        <div class="panel-body">-->
<!--            <!-- -/->-->
<!--            --><?//= GridView::widget([
//                'dataProvider' => $posts,
//                'columns' => [
//                    [
//                        'attribute' => 'title',
//                        'format' => 'raw',
//                        'value' => function($postModel){
////                                {{ html.a(model.title,{0: 'post/view','id': model.id,'title':model.title}) | raw }}
////                                ['id' => $postModel->id, 'title' => $postModel->title]
//                            return \yii\helpers\Html::a($postModel->title,['post/view','id'=>$postModel->id]);
//                        },
//                    ],
//                    [
//                        'attribute' => 'view',
//                        'value' => 'view',
//                    ],
//                    [
//                        'attribute' => 'status',
//                        'value' => function($postModel){
//                            $postStatus = $postModel->postStatus();
//                            return $postStatus[$postModel->status];
//                        },
//                        'filter' => $postModel->postStatus()
//                    ],
//                    [
//                        'attribute' => 'create_time',
//                        'value' => function($postModel){
//                            return Yii::$app->date->pdate($postModel->create_time);
//                        },
//                        'filter' => ''
//                    ],
//                ],
//            ]); ?>
<!--            <!-- -/->-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

<!--<div class="col-md-12">-->
<!--    <div class="panel panel-default">-->
<!--        <div class="panel-heading">--><?//= Yii::t('app','Most Viewed Files') ?><!--</div>-->
<!--        <div class="panel-body">-->
<!--            <!-- -/->-->
<!--            --><?//= GridView::widget([
//                'dataProvider' => $files,
//                'columns' => [
//                    [
//                        'attribute' => 'name'
//                    ],
//                    'extension',
//                    [
//                        'attribute' => 'size',
//                        'value' => function($fileModel){
//                            if ($fileModel->size<1048676)
//                                return number_format($fileModel->size/1024,1) . ' ' . Yii::t('app','KB');
//                            else
//                                return number_format($fileModel->size/1048576,1) . ' ' . Yii::t('app','MB');
//                        },
//                        'filter' => ''
//                    ],
//                    [
//                        'attribute' => 'download_count',
//                        'filter' => ''
//                    ],
//                    [
//                        'attribute' => 'upload_date',
//                        'value' => function($fileModel){
//                            return Yii::$app->date->pdate($fileModel->upload_date);
//                        },
//                        'filter' => ''
//                    ]
//                ],
//            ]); ?>
<!--            <!-- -/->-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->