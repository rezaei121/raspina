<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\themes\theme01;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Asset extends AssetBundle
{
    public $basePath = '@theme';
    public $baseUrl = '@themeUrl';
    public $css = [
        'css/reset.css',
        'css/font-awesome.min.css',
        'css/style.css',
    ];
    public $js = [
        'js/prism.js',
        'js/mycode.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
