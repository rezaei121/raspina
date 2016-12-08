<?php
/**
 * @link https://github.com/mrlco/yii2-jalali-datepicker#readme
 * @license https://github.com/mrlco/yii2-jalali-datepicker/blob/master/LICENSE
 * @copyright Copyright (c) 2015 Mrlco
 */

namespace mrlco\datepicker;

use yii\web\AssetBundle;

/**
 * Asset bundle for the Persian Bootstrap Datepicker Dark theme css files.
 *
 * @author Mehran Barzandeh <merhan.barzandeh@gmail.com>
 */
class DatepickerDarkThemeAsset extends AssetBundle
{
    public $sourcePath = '@vendor/mrlco/datepicker/dist';
    public $css = [
        'css/theme/persian-datepicker-dark.css',
    ];
    public $js = [
        'js/persian-datepicker-0.4.5.js',
    ];
    public $depends = [
        'mrlco\datepicker\DateAsset',
    ];
}
