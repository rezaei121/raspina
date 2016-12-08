<?php
namespace developit\captcha;

use yii\web\AssetBundle;
use Yii;

class yii2CaptchaAsset extends AssetBundle
{
    public $sourcePath = '@vendor/developit/yii2-captcha/assets';
    public $js = ['yii.captcha.validation.js'];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}