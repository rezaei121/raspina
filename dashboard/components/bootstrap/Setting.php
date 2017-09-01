<?php
namespace dashboard\components\bootstrap;

use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;

class Setting implements BootstrapInterface
{

    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        try
        {
            $settingModel = \dashboard\modules\setting\models\Setting::find()->one();

            Yii::$app->language = $settingModel->language;
            Yii::$app->timeZone = $settingModel->time_zone;
            Yii::$app->date->locale = $settingModel->language;
            Yii::$app->date->defaultTimeZone = $settingModel->time_zone;
            Yii::$app->date->datetimeFormat = $settingModel->date_format;
            Yii::$app->params['direction'] = $settingModel->direction;
            Yii::$app->params['lang'] = (explode('-',$settingModel->language))[0];
            Yii::$app->hashids->salt = $settingModel->sult;
            Yii::$app->hashids->init();

            if($settingModel->direction == 'rtl')
            {
                $app->view->registerCssFile(Yii::$app->homeUrl . 'web/css/bootstrap-rtl.min.css', ['depends' => ['yii\bootstrap\BootstrapAsset']]);
            }
        }
        catch (\Exception $e)
        {

        }
    }
}