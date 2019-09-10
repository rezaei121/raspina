<?php
namespace app\components\bootstrap;

use app\components\helpers\Html;
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
            $settingModel = \app\modules\setting\models\Setting::find()->one();
            Yii::$app->language = $settingModel->language;
            Yii::$app->timeZone = $settingModel->time_zone;
            Yii::$app->date->locale = $settingModel->language;
            Yii::$app->date->defaultTimeZone = $settingModel->time_zone;
            Yii::$app->date->datetimeFormat = $settingModel->date_format;
            Yii::$app->params['pageSize'] = $settingModel->page_size;
            Yii::$app->params['url'] = $settingModel->url;
            Yii::$app->params['direction'] = $settingModel->direction;
            Yii::$app->params['lang'] = (explode('-',$settingModel->language))[0];
            Yii::$app->params['template'] = $settingModel->template;
            Yii::$app->params['templateUrl'] = $settingModel->url . 'themes/' . $settingModel->template;
            Yii::$app->params['templateDir'] = \Yii::getAlias('@app') . DIRECTORY_SEPARATOR . 'themes' . DIRECTORY_SEPARATOR . $settingModel->template;
            Yii::$app->params['templateLayout'] = \Yii::getAlias('@app') . DIRECTORY_SEPARATOR . 'themes' . DIRECTORY_SEPARATOR . $settingModel->template;
            Yii::setAlias('@theme', Yii::$app->params['templateLayout']);
            Yii::setAlias('@themeUrl', Yii::$app->params['templateUrl']);
            Yii::$app->hashids->salt = $settingModel->sult;

            Yii::$app->hashids->init();

            # charset
            Yii::$app->params['charset'] = Yii::$app->charset;
            # csrfMetaTags
            Yii::$app->params['csrfMetaTags'] = Html::csrfMetaTags();
            Yii::$app->params['subject'] = $settingModel->title;
            Yii::$app->view->title = $settingModel->title;
            Yii::$app->params['siteDescription'] = $settingModel->description;
            Yii::$app->params['keywords'] = $settingModel->keyword;
        }
        catch (\Exception $e)
        {

        }
    }
}
