<?php
namespace developit\captcha;
use Yii;
use developit\captcha\yii2CaptchaAsset;

class Captcha extends \yii\captcha\Captcha
{
    public function run()
    {
        $this->registerClientScript();
        parent::run();
    }

    public function registerClientScript()
    {
        yii2CaptchaAsset::register(Yii::$app->getView());
        parent::registerClientScript();
    }
}
