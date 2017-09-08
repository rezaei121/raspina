<?php
namespace frontend\components\bootstrap;

use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\helpers\Html;

class Setting implements BootstrapInterface
{

    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        $settingModel = \dashboard\modules\setting\models\Setting::find()->one();

        Yii::$app->language = $settingModel->language;
        Yii::$app->timeZone = $settingModel->time_zone;
        Yii::$app->date->locale = $settingModel->language;
        Yii::$app->date->defaultTimeZone = $settingModel->time_zone;
        Yii::$app->date->datetimeFormat = $settingModel->date_format;
        Yii::$app->params['url'] = $settingModel->url;
        Yii::$app->params['direction'] = $settingModel->direction;
        Yii::$app->params['lang'] = (explode('-',$settingModel->language))[0];
        Yii::$app->hashids->salt = $settingModel->sult;
        Yii::$app->hashids->init();

        if($settingModel->direction == 'rtl')
        {
            $app->view->registerCssFile(Yii::$app->homeUrl . 'web/css/bootstrap-rtl.min.css', ['depends' => [\dashboard\assets\AppAsset::className()]]);
        }

        if($settingModel->direction == 'rtl')
        {

        }

        // blog setting
        $setting = \Yii::$app->setting->get();
        # description
        if(isset($this->view->params['description']) && !empty($this->view->params['description']))
        {
            Yii::$app->view->params['description'] = $setting['description'] . ' - ' . Yii::$app->view->params['description'];
        }
        else
        {
            if(isset($setting['description']) && !empty($setting['description']))
            {
                Yii::$app->view->params['description'] = $setting['description'];
            }
            else
            {
                Yii::$app->view->params['description'] = '';
            }
        }
        # keywords
        if(isset($this->view->params['keywords']) && !empty($this->view->params['keywords']))
        {
            Yii::$app->view->params['keywords'] = $setting['keyword'] . ',' . Yii::$app->view->params['keywords'];
        }
        else
        {
            if(isset($setting['keyword']) && !empty($setting['keyword']))
            {
                Yii::$app->view->params['keywords'] = $setting['keyword'];
            }
            else
            {
                Yii::$app->view->params['keywords'] = '';
            }
        }
        # templateUrl
        Yii::$app->view->params['templateUrl'] = $setting['templateUrl'];
        # templateDir
        Yii::$app->view->params['templateDir'] = $setting['templateDir'];
        # title
        Yii::$app->view->title = $setting['title'];

        Yii::$app->view->params['subject'] = $setting['title'];
        Yii::$app->view->params['siteDescription'] = $setting['description'];
        # lang
        Yii::$app->view->params['lang'] = Yii::$app->language;
        # charset
        Yii::$app->view->params['charset'] = Yii::$app->charset;
        # csrfMetaTags
        Yii::$app->view->params['csrfMetaTags'] = Html::csrfMetaTags();
        # url
        Yii::$app->view->params['url'] = $setting['url'];
        # categories
        Yii::$app->view->params['categories'] = \common\models\Category::getAll();
        # links
        Yii::$app->view->params['links'] = \common\models\Link::find()->all();
        # model
        Yii::$app->view->params['newsletter'] = new \frontend\models\Newsletter;
        # site
        Yii::$app->view->params['index'] = new \frontend\models\Site;
    }
}