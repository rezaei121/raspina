<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace dashboard\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = 'web/@webroot';
    public $baseUrl = '@web';
    public $css = [
        'web/css/bootstrap.min.css',
        'web/css/bootstrap-rtl.min.css',
        'web/css/reset.css',
        'web/css/index2.css',
        'web/css/font-awesome.min.css'
    ];
    public $js = [
        'web/js/bootstrap.min.js',
        'web/js/mycode.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
