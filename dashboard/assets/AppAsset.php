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
    public $basePath = '@webroot';
    public $baseUrl = '@web/web';

    public $css = [
        'css/bootstrap.min.css',
        'css/bootstrap-rtl.min.css',
        'css/reset.css',
        'css/index2.css',
        'css/font-awesome.min.css'
    ];
    public $js = [
        'js/bootstrap.min.js',
        'js/mycode.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
