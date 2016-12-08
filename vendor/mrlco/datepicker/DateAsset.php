<?php
/**
 * @link https://github.com/mrlco/yii2-jalali-datepicker#readme
 * @license https://github.com/mrlco/yii2-jalali-datepicker/blob/master/LICENSE
 * @copyright Copyright (c) 2015 Mrlco
 */

namespace mrlco\datepicker;

use yii\web\AssetBundle;

/**
 * Asset bundle for the Persian Datepicker css files.
 *
 * @author Mehran Barzandeh <merhan.barzandeh@gmail.com>
 */
class DateAsset extends AssetBundle
{
    public $sourcePath = '@vendor/mrlco/datepicker/dist';
    public $js = [
        'js/pwt-date.js',
        'js/persian-datepicker-0.4.5.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
